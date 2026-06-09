<?php

namespace App\Controllers;

use App\Models\ModelPengguna;


class User extends BaseController
{
    // ========================================
    // DASHBOARD SECTION - READ OPERATIONS
    // ========================================
    
    public function dashboard()
    {
        // Security check - ensure only users can access this page
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        // Additional security - check if user is logged in
        if (!session()->has('id')) {
            return redirect()->to('/login');
        }

        // Initialize variables and database connections
        $userId = session()->get('id');
        $model = new ModelPengguna();
        $db = \Config\Database::connect();

        // Set timezone to Malaysia and get current date
        $now = new \DateTime('now', new \DateTimeZone('Asia/Kuala_Lumpur'));
        $today = $now->format('Y-m-d');

        // Check if user has already claimed daily reward today
        $hasClaimed = $db->table('daily_logins')
            ->where('user_id', $userId)
            ->where('login_date', $today)
            ->countAllResults() > 0;

        // Get user data and login streak information
        $userData = $model->find($userId);
        $lastLogin = $userData->last_login_date ?? null;
        $streak = $userData->login_streak ?? 0;

        // Calculate countdown timer for next daily reward claim
        $midnight = new \DateTime('tomorrow midnight', new \DateTimeZone('Asia/Kuala_Lumpur'));
        $secondsRemaining = $midnight->getTimestamp() - $now->getTimestamp();
        $nextClaimCountdown = gmdate('H:i:s', $secondsRemaining);

        // Get list of completed tasks for this user
        $completedTasks = $db->table('user_tasks')
            ->select('task_key')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();
        $completedTaskKeys = array_column($completedTasks, 'task_key');

        // ✨ NEW: GET ACTIVE QUESTS FOR DASHBOARD DISPLAY
        // This joins user_quests with quests table to get complete quest information
        // Only fetches quests with 'pending' status (accepted but not completed)
        $activeQuests = $db->table('user_quests uq')
            ->select('uq.*, q.title, q.description, q.ecopoints_reward, q.xp_reward, q.type')
            ->join('quests q', 'q.id = uq.quest_id')
            ->where('uq.user_id', $userId)
            ->where('uq.status', 'pending')
            ->get()
            ->getResult();

        // Prepare data array for the view
        $data = [
            'topUsers' => $model->getTop10Leaderboard(),
            'userRank' => $model->getUserRank($userId),
            'userData' => $userData,
            'hasClaimedToday' => $hasClaimed,
            'loginStreak' => $streak,
            'nextClaimCountdown' => $nextClaimCountdown,
            'completedTasks' => $completedTaskKeys,
            'activeQuests' => $activeQuests  // ✨ NEW: Pass active quests to view
        ];

        return view('user/main', $data);
    }

    // ========================================
    // DAILY REWARD SYSTEM - CREATE/UPDATE OPERATIONS
    // ========================================
    

    public function claimDailyReward()
    {
        // Security check - ensure only users can claim rewards
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        // Initialize variables and get current date
        $userId = session()->get('id');
        $db = \Config\Database::connect();
        $now = new \DateTime('now', new \DateTimeZone('Asia/Kuala_Lumpur'));
        $today = $now->format('Y-m-d');

        $model = new ModelPengguna();
        $user = $model->find($userId);

        // Check if user has already claimed today's reward
        $alreadyClaimed = $db->table('daily_logins')
            ->where('user_id', $userId)
            ->where('login_date', $today)
            ->countAllResults();

        if ($alreadyClaimed > 0) {
            session()->setFlashdata('claim_error', 'You have already claimed today.');
            return redirect()->to('/user');
        }

        // Calculate login streak
        $lastLogin = $user->last_login_date ?? null;
        $yesterday = (clone $now)->modify('-1 day')->format('Y-m-d');
        $streak = ($lastLogin === $yesterday) ? ($user->login_streak ?? 0) + 1 : 1;

        // Base reward amounts
        $bonus = 10;
        $xpBonus = 15; // Base XP for daily login
        $bonusMessage = '';

        // Apply subscription plan multipliers
        $plan = $user->subscription_plan ?? 'basic';
        $multiplier = 1;
        switch ($plan) {
            case 'gold':
                $multiplier = 2;
                break;
            case 'diamond':
                $multiplier = 3;
                break;
        }

        $bonus *= $multiplier;
        $xpBonus *= $multiplier;

        // Apply streak bonuses (every 7 days)
        if ($streak % 7 === 0) {
            $bonus += 15;
            $xpBonus += 25;
            $bonusMessage = ' 🎉 7-day streak bonus!';
        }

        // Record the daily login
        $db->table('daily_logins')->insert([
            'user_id' => $userId,
            'login_date' => $today
        ]);

        // Update user's points, XP, and streak
        $model->update($userId, [
            'ecopoints' => $user->ecopoints + $bonus,
            'xp' => ($user->xp ?? 0) + $xpBonus,
            'login_streak' => $streak,
            'last_login_date' => $today
        ]);

        // Mark daily login task as completed (ignore if already exists)
        try {
            $db->table('user_tasks')->insert([
                'user_id' => $userId,
                'task_key' => 'daily_login'
            ]);
        } catch (\Exception $e) {}

        session()->setFlashdata('claim_success', "Daily reward claimed! +{$bonus} EcoPoints, +{$xpBonus} XP." . $bonusMessage);
        return redirect()->to('/user');
    }

    // ========================================
    // TASK COMPLETION SYSTEM - CREATE/UPDATE OPERATIONS
    // ========================================

    public function completeTask()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $taskKey = $this->request->getPost('task_key');

        if ($taskKey) {
            $db = \Config\Database::connect();
            $model = new ModelPengguna();
            $user = $model->find($userId);

            // Define reward amounts for different tasks
            $taskRewards = [
                'daily_login' => ['ecopoints' => 10, 'xp' => 15],
                'submit_water_meter' => ['ecopoints' => 15, 'xp' => 20],
                'upload_water_bill' => ['ecopoints' => 20, 'xp' => 25],
                'complete_profile' => ['ecopoints' => 15, 'xp' => 20],
            ];

            try {
                // Record task completion
                $db->table('user_tasks')->insert([
                    'user_id' => $userId,
                    'task_key' => $taskKey
                ]);

                // Award points and XP based on task type
                if (isset($taskRewards[$taskKey])) {
                    $reward = $taskRewards[$taskKey];
                    $model->update($userId, [
                        'ecopoints' => $user->ecopoints + $reward['ecopoints'],
                        'xp' => ($user->xp ?? 0) + $reward['xp']
                    ]);
                    
                    session()->setFlashdata('claim_success', 
                        "Task completed! +{$reward['ecopoints']} EcoPoints, +{$reward['xp']} XP");
                } else {
                    session()->setFlashdata('claim_success', 'Task marked as completed!');
                }
            } catch (\Exception $e) {
                // Handle duplicate task completion
                session()->setFlashdata('claim_error', 'Task already completed or error occurred.');
            }
        }

        return redirect()->to('/user');
    }

    // ========================================
    // QUEST MANAGEMENT SYSTEM - READ/CREATE/UPDATE/DELETE OPERATIONS ✨ UPDATED
    // ========================================
    

    public function quest()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $db = \Config\Database::connect();

        // Get all available quests from database
        $allQuests = $db->table('quests')->get()->getResult();
        
        // Get user's quest progress and status
        $userQuests = $db->table('user_quests')
            ->where('user_id', $userId)
            ->get()
            ->getResult();

        // Convert user quests to associative array for easier lookup
        $userQuestStatus = [];
        foreach ($userQuests as $userQuest) {
            $userQuestStatus[$userQuest->quest_id] = $userQuest;
        }

        return view('nav/quest', [
            'allQuests' => $allQuests,
            'userQuests' => $userQuests,
            'userQuestStatus' => $userQuestStatus
        ]);
    }

    public function acceptQuest()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $questId = $this->request->getPost('quest_id');

        if (!$questId) {
            return redirect()->back()->with('error', 'No quest selected.');
        }

        $db = \Config\Database::connect();

        // Check if quest is already accepted by this user
        $existing = $db->table('user_quests')
            ->where('user_id', $userId)
            ->where('quest_id', $questId)
            ->countAllResults();

        if ($existing > 0) {
            return redirect()->back()->with('error', 'You already accepted this quest.');
        }

        // Get quest details for confirmation message
        $quest = $db->table('quests')->where('id', $questId)->get()->getRow();
        if (!$quest) {
            return redirect()->back()->with('error', 'Quest not found.');
        }

        // Record quest acceptance
        $db->table('user_quests')->insert([
            'user_id' => $userId,
            'quest_id' => $questId,
            'status' => 'pending',
            'accepted_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', "Quest '{$quest->title}' accepted successfully!");
    }


    public function completeQuest()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $questId = $this->request->getPost('quest_id');

        if (!$questId) {
            return redirect()->back()->with('error', 'No quest selected.');
        }

        $db = \Config\Database::connect();
        $model = new ModelPengguna();

        // Get quest details and rewards
        $quest = $db->table('quests')->where('id', $questId)->get()->getRow();
        if (!$quest) {
            return redirect()->back()->with('error', 'Quest not found.');
        }

        // Check if user has accepted this quest
        $userQuest = $db->table('user_quests')
            ->where('user_id', $userId)
            ->where('quest_id', $questId)
            ->get()->getRow();

        if (!$userQuest) {
            return redirect()->back()->with('error', 'You must accept this quest first.');
        }

        if ($userQuest->status === 'completed') {
            return redirect()->back()->with('error', 'Quest already completed.');
        }

        // Mark quest as completed
        $db->table('user_quests')
            ->where('user_id', $userId)
            ->where('quest_id', $questId)
            ->update([
                'status' => 'completed',
                'completed_at' => date('Y-m-d H:i:s')
            ]);

        // Award quest rewards to user
        $user = $model->find($userId);
        $model->update($userId, [
            'ecopoints' => $user->ecopoints + $quest->ecopoints_reward,
            'xp' => ($user->xp ?? 0) + $quest->xp_reward,
        ]);

        return redirect()->back()->with('success', 
            "Quest '{$quest->title}' completed! +{$quest->ecopoints_reward} EcoPoints, +{$quest->xp_reward} XP");
    }


    public function cancelQuest()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $questId = $this->request->getPost('quest_id');

        if (!$questId) {
            return redirect()->back()->with('error', 'No quest selected.');
        }

        $db = \Config\Database::connect();

        // Get quest details for confirmation message
        $quest = $db->table('quests')->where('id', $questId)->get()->getRow();
        if (!$quest) {
            return redirect()->back()->with('error', 'Quest not found.');
        }

        // Check if user has accepted this quest
        $userQuest = $db->table('user_quests')
            ->where('user_id', $userId)
            ->where('quest_id', $questId)
            ->get()->getRow();

        if (!$userQuest) {
            return redirect()->back()->with('error', 'Quest not found or not accepted.');
        }

        // Don't allow canceling completed quests
        if ($userQuest->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot cancel completed quests.');
        }

        // ✨ DELETE the quest acceptance record
        // This removes the user's progress and allows them to start fresh
        $db->table('user_quests')
            ->where('user_id', $userId)
            ->where('quest_id', $questId)
            ->delete();

        return redirect()->back()->with('success', "Quest '{$quest->title}' cancelled successfully! You can accept it again anytime.");
    }

    // ========================================
    // ACHIEVEMENT SYSTEM - READ/CREATE OPERATIONS
    // ========================================
    

    public function achievement()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $db = \Config\Database::connect();
        $model = new ModelPengguna();

        // Get all achievements from database
        $achievements = $db->table('achievements')->get()->getResult();
        $user = $model->find($userId);
        
        // Get user's unlocked achievements
        $unlocked = $db->table('user_achievements')
            ->select('achievement_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        $unlockedIds = array_column($unlocked, 'achievement_id');

        // Check for new achievements that can be unlocked
        $this->checkAndUnlockAchievements($userId, $user);

        return view('nav/achievement', [
            'achievements' => $achievements,
            'unlockedIds' => $unlockedIds,
            'userData' => $user
        ]);
    }


    private function checkAndUnlockAchievements($userId, $user)
    {
        $db = \Config\Database::connect();
        $model = new ModelPengguna();

        // Get all available achievements
        $achievements = $db->table('achievements')->get()->getResult();
        
        foreach ($achievements as $achievement) {
            // Skip if achievement is already unlocked
            $alreadyUnlocked = $db->table('user_achievements')
                ->where('user_id', $userId)
                ->where('achievement_id', $achievement->id)
                ->countAllResults() > 0;

            if ($alreadyUnlocked) continue;

            $shouldUnlock = false;

            // Check different achievement conditions based on category
            switch ($achievement->category) {
                case 'level':
                    // Level-based achievements (XP / 100 = level)
                    $userLevel = floor(($user->xp ?? 0) / 100);
                    $shouldUnlock = $userLevel >= $achievement->level_required;
                    break;
                    
                case 'login_streak':
                    // Login streak achievements
                    $shouldUnlock = ($user->login_streak ?? 0) >= $achievement->level_required;
                    break;
                    
                case 'beginner':
                    // Beginner achievements for first actions
                    $taskCount = $db->table('user_tasks')->where('user_id', $userId)->countAllResults();
                    $shouldUnlock = $taskCount >= 1;
                    break;
            }

            if ($shouldUnlock) {
                // Unlock the achievement
                $db->table('user_achievements')->insert([
                    'user_id' => $userId,
                    'achievement_id' => $achievement->id,
                    'unlocked_at' => date('Y-m-d H:i:s')
                ]);

                // Award bonus EcoPoints for unlocking achievement
                $bonusPoints = 50; // Base bonus for unlocking achievement
                $model->update($userId, [
                    'ecopoints' => $user->ecopoints + $bonusPoints
                ]);
            }
        }
    }

    // ========================================
    // REWARD STORE SYSTEM - READ/CREATE OPERATIONS
    // ========================================
    

    public function rewardStore()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $model = new ModelPengguna();
        $db = \Config\Database::connect();

        $userData = $model->find($userId);
        // Get only available rewards
        $rewards = $db->table('rewards')->where('available', 1)->get()->getResult();

        // Get user's already redeemed rewards
        $redeemedRewards = $db->table('user_rewards')
            ->select('reward_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();
        $redeemedIds = array_column($redeemedRewards, 'reward_id');

        return view('nav/rewardstore', [
            'rewards' => $rewards,
            'userData' => $userData,
            'redeemedIds' => $redeemedIds
        ]);
    }


    public function redeemReward()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $rewardId = $this->request->getPost('reward_id');
        $userId = session()->get('id');

        $db = \Config\Database::connect();
        $model = new ModelPengguna();

        // Get user and reward data
        $user = $model->find($userId);
        $reward = $db->table('rewards')->getWhere(['id' => $rewardId])->getRow();

        if (!$reward || !$user) {
            return redirect()->back()->with('error', 'Invalid reward or user.');
        }

        // Check if user has enough EcoPoints
        if ($user->ecopoints < $reward->cost_ecopoints) {
            return redirect()->back()->with('error', 'Not enough EcoPoints to redeem.');
        }

        // Check if reward is already redeemed
        $alreadyRedeemed = $db->table('user_rewards')
            ->where('user_id', $userId)
            ->where('reward_id', $reward->id)
            ->countAllResults() > 0;

        if ($alreadyRedeemed) {
            return redirect()->back()->with('error', 'You have already redeemed this reward.');
        }

        // Deduct EcoPoints from user account
        $model->update($userId, [
            'ecopoints' => $user->ecopoints - $reward->cost_ecopoints
        ]);

        // Record reward redemption
        $db->table('user_rewards')->insert([
            'user_id' => $userId,
            'reward_id' => $reward->id,
            'redeemed_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Reward redeemed successfully!');
    }

    // ========================================
    // USER SETTINGS SYSTEM - READ/UPDATE OPERATIONS
    // ========================================
    

    public function settings()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $model = new ModelPengguna();
        $user = $model->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Define available profile customization options
        $profilePictures = [
            ['filename' => 'default1.png', 'locked' => false],
            ['filename' => 'default2.png', 'locked' => false],
            ['filename' => 'default3.png', 'locked' => false],
            ['filename' => 'default4.png', 'locked' => false],
            ['filename' => 'locked1.png', 'locked' => true],
            ['filename' => 'locked2.png', 'locked' => true],
        ];

        $profileBorders = [
            'none' => 'No Border',
            'blue-glow' => 'Blue Glow',
            'green-frame' => 'Green Frame',
            'gold-crown' => 'Gold Crown (Locked)',
        ];

        return view('nav/setting', [
            'userData' => (array) $user,
            'profilePictures' => $profilePictures,
            'profileBorders' => $profileBorders,
        ]);
    }


    public function updateProfile()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $model = new ModelPengguna();

        $profilePic = $this->request->getPost('profile_pic');
        $border = $this->request->getPost('pfp_border');

        // Prepare update data
        $updateData = [];
        if ($profilePic) {
            $updateData['profile_pic'] = $profilePic;
        }
        if ($border) {
            $updateData['border_style'] = $border;
        }

        // Update profile if there are changes
        if (!empty($updateData)) {
            $model->update($userId, $updateData);
            session()->setFlashdata('success', 'Profile updated successfully!');
        }

        return redirect()->to('/user/settings');
    }


    public function updateWater()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $db = \Config\Database::connect();
        $model = new ModelPengguna();

        $waterReading = $this->request->getPost('water_reading');
        $proofFile = $this->request->getFile('proof_photo');

        // Validate required inputs
        if (!$waterReading || !$proofFile || !$proofFile->isValid()) {
            return redirect()->back()->with('error', 'Please provide both water reading and proof photo.');
        }

        // Set up upload directory for proof photos
        $uploadPath = WRITEPATH . 'uploads/water_proofs/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Upload proof photo with random name
        $newName = $proofFile->getRandomName();
        if ($proofFile->move($uploadPath, $newName)) {
            // Save water usage log to database
            $db->table('water_usage_logs')->insert([
                'user_id' => $userId,
                'reading_value' => $waterReading,
                'proof_photo_path' => 'uploads/water_proofs/' . $newName,
                'submitted_at' => date('Y-m-d H:i:s')
            ]);

            // Award points for water usage submission
            $user = $model->find($userId);
            $model->update($userId, [
                'ecopoints' => $user->ecopoints + 20,
                'xp' => ($user->xp ?? 0) + 25
            ]);

            // Mark water meter submission task as completed
            try {
                $db->table('user_tasks')->insert([
                    'user_id' => $userId,
                    'task_key' => 'submit_water_meter'
                ]);
            } catch (\Exception $e) {}

            session()->setFlashdata('success', 'Water usage updated successfully! +20 EcoPoints, +25 XP');
        } else {
            session()->setFlashdata('error', 'Failed to upload proof photo.');
        }

        return redirect()->to('/user/settings');
    }

    // ========================================
    // SUBSCRIPTION MANAGEMENT SYSTEM - CREATE/UPDATE OPERATIONS
    // ========================================
    
    public function upgradeSubscription()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $plan = $this->request->getPost('plan');
        $amount = $this->request->getPost('amount');

        // Store subscription details in session for payment processing
        session()->set('pending_subscription', [
            'plan' => $plan,
            'amount' => $amount
        ]);

        return redirect()->to('/user/settings')->with('info', 'Please complete payment to upgrade your subscription.');
    }


    public function processPayment()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $model = new ModelPengguna();
        $db = \Config\Database::connect();

        // Get payment form data
        $plan = $this->request->getPost('plan');
        $amount = $this->request->getPost('amount');
        $cardNumber = $this->request->getPost('card_number');
        $expiryDate = $this->request->getPost('expiry_date');
        $cvv = $this->request->getPost('cvv');
        $cardName = $this->request->getPost('card_name');

        // Validate all payment fields are provided
        if (!$plan || !$amount || !$cardNumber || !$expiryDate || !$cvv || !$cardName) {
            return redirect()->back()->with('error', 'Please fill in all payment details.');
        }

        // Simulate payment processing (In real app, integrate with payment gateway like Stripe)
        $paymentSuccess = true; // This would be the actual result from payment gateway

        if ($paymentSuccess) {
            // Update user's subscription plan
            $model->update($userId, [
                'subscription_plan' => $plan
            ]);

            // Log payment transaction for record keeping
            $db->table('subscription_payments')->insert([
                'user_id' => $userId,
                'plan' => $plan,
                'amount' => $amount,
                'payment_method' => 'credit_card',
                'transaction_id' => 'TXN_' . time() . '_' . $userId,
                'status' => 'completed',
                'paid_at' => date('Y-m-d H:i:s')
            ]);

            // Award bonus EcoPoints based on subscription tier
            $user = $model->find($userId);
            $bonusPoints = ($plan === 'gold') ? 100 : 250; // Gold: 100, Diamond: 250
            $model->update($userId, [
                'ecopoints' => $user->ecopoints + $bonusPoints
            ]);

            session()->setFlashdata('success', "Subscription upgraded to {$plan} successfully! +{$bonusPoints} bonus EcoPoints!");
        } else {
            session()->setFlashdata('error', 'Payment failed. Please try again.');
        }

        return redirect()->to('/user/settings');
    }

    // ========================================
    // SECURITY MANAGEMENT - UPDATE OPERATIONS
    // ========================================
    
    public function changePassword()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $model = new ModelPengguna();

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $user = $model->find($userId);

        // Verify current password is correct
        if (!password_verify($currentPassword, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Ensure new passwords match
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'New passwords do not match.');
        }

        // Update password with secure hashing
        $model->update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
        session()->setFlashdata('success', 'Password changed successfully.');
        return redirect()->to('/user/settings');
    }

    // ========================================
    // LEADERBOARD SYSTEM - READ OPERATIONS
    // ========================================
    

    public function leaderboard()
    {
        // Security check
        if (session()->get('userlevel') !== 'user') {
            return redirect()->to('/');
        }

        $userId = session()->get('id');
        $model = new ModelPengguna();

        $data = [
            'topUsers' => $model->getTop10Leaderboard(),
            'userRank' => $model->getUserRank($userId),
            'userData' => $model->find($userId),
        ];

        return view('nav/leaderboard', $data);
    }
}


// ========================================
// END OF USER CONTROLLER
// ========================================
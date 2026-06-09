<?php

namespace App\Controllers;

use App\Models\ModelPengguna;
use App\Models\ModelAchievement;
use App\Models\ModelReward;
use App\Models\ModelQuest;


class Admin extends BaseController
{
    // ========================================
    // CONTROLLER INITIALIZATION
    // ========================================
    
    protected $model;
    protected $achievementModel;
    protected $rewardModel;
    protected $questModel;


    public function __construct()
    {
        $this->model = new ModelPengguna();
        $this->achievementModel = new ModelAchievement();
        $this->rewardModel = new ModelReward();
        $this->questModel = new ModelQuest();
    }

    // ========================================
    // ADMIN DASHBOARD SECTION - READ OPERATIONS
    // ========================================
    

    public function dashboard()
    {
        // Security check - ensure only admins can access
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        
        // Get comprehensive system statistics
        $totalUsers = $this->model->where('userlevel', 'user')->countAllResults();
        $totalAdmins = $this->model->where('userlevel', 'admin')->countAllResults();
        $totalAchievements = $this->achievementModel->countAllResults();
        $totalRewards = $this->rewardModel->countAllResults();
        $totalQuests = $this->questModel->countAllResults();
        
        // Get recent user registrations (last 5 users)
        $recentUsers = $this->model->where('userlevel', 'user')
                                  ->orderBy('created_at', 'DESC')
                                  ->limit(5)
                                  ->findAll();

        // Get top performing users by EcoPoints
        $topUsers = $this->model->where('userlevel', 'user')
                               ->orderBy('ecopoints', 'DESC')
                               ->limit(5)
                               ->findAll();

        // Get today's login activity
        $todayLogins = $db->table('daily_logins')
                         ->where('login_date', date('Y-m-d'))
                         ->countAllResults();

        // Prepare data array for dashboard view
        $data = [
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalAchievements' => $totalAchievements,
            'totalRewards' => $totalRewards,
            'totalQuests' => $totalQuests,
            'recentUsers' => $recentUsers,
            'topUsers' => $topUsers,
            'todayLogins' => $todayLogins
        ];

        return view('admin/main', $data);
    }

    // ========================================
    // USER MANAGEMENT SECTION - FULL CRUD OPERATIONS
    // ========================================
    

    public function manageUsers()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        $searchTxt = $this->request->getGet('search');
        
        // Apply search filter if search term is provided
        if ($searchTxt !== null) {
            $users = $this->model->like('username', $searchTxt)
                                ->orLike('fullname', $searchTxt)
                                ->orLike('email', $searchTxt)
                                ->findAll();
        } else {
            // Get all users if no search term
            $users = $this->model->findAll();
        }

        return view('admin/manage_users', ['users' => $users, 'search' => $searchTxt]);
    }


    public function addUser()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            
            // Define validation rules for new user
            $rules = [
                'fullname' => 'required|min_length[3]',
                'username' => 'required|min_length[3]|is_unique[pengguna.username]',
                'email' => 'required|valid_email|is_unique[pengguna.email]',
                'password' => 'required|min_length[6]',
                'userlevel' => 'required|in_list[admin,user]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/add_user', ['validation' => $this->validator]);
            }

            // Create new user with validated data
            $this->model->insert([
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'userlevel' => $this->request->getPost('userlevel')
            ]);

            return redirect()->to('/admin/manage-users')->with('success', 'User added successfully.');
        }

        // Display add user form (GET request)
        return view('admin/add_user');
    }


    public function editUser($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Get user data for editing
        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules (excluding current user from unique checks)
            $rules = [
                'fullname' => 'required|min_length[3]',
                'username' => "required|min_length[3]|is_unique[pengguna.username,id,{$id}]",
                'email' => "required|valid_email|is_unique[pengguna.email,id,{$id}]",
                'userlevel' => 'required|in_list[admin,user]',
            ];

            // Add password validation only if password is being changed
            if (!empty($this->request->getPost('password'))) {
                $rules['password'] = 'min_length[6]';
            }

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/edit_user', ['user' => $user, 'validation' => $this->validator]);
            }

            // Prepare update data
            $updateData = [
                'fullname' => $this->request->getPost('fullname'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'userlevel' => $this->request->getPost('userlevel'),
                'ecopoints' => $this->request->getPost('ecopoints'),
                'xp' => $this->request->getPost('xp'),
            ];

            // Include password in update if provided
            if (!empty($this->request->getPost('password'))) {
                $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            // Update user record
            $this->model->update($id, $updateData);

            return redirect()->to('/admin/manage-users')->with('success', 'User updated successfully.');
        }

        // Display edit user form (GET request)
        return view('admin/edit_user', ['user' => $user]);
    }


    public function deleteUser($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Verify user exists
        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Prevent admin from deleting their own account
        if ($id == session()->get('id')) {
            return redirect()->back()->with('error', 'You cannot delete your own account');
        }

        // Delete user from database
        $this->model->delete($id);
        return redirect()->to('/admin/manage-users')->with('success', 'User deleted successfully.');
    }

    // ========================================
    // ACHIEVEMENT MANAGEMENT SECTION - FULL CRUD OPERATIONS
    // ========================================
    
    public function manageAchievements()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        $achievements = $this->achievementModel->getAllAchievements();
        return view('admin/manage_achievements', ['achievements' => $achievements]);
    }


    public function addAchievement()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules for new achievement
            $rules = [
                'title' => 'required|min_length[3]',
                'description' => 'required',
                'level_required' => 'required|integer',
                'category' => 'required',
                'tier' => 'required|in_list[bronze,silver,gold]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/add_achievement', ['validation' => $this->validator]);
            }

            // Create new achievement with validated data
            $this->achievementModel->insert([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'image_path' => $this->request->getPost('image_path') ?: '/images/achievements/default.png',
                'level_required' => $this->request->getPost('level_required'),
                'category' => $this->request->getPost('category'),
                'tier' => $this->request->getPost('tier')
            ]);

            return redirect()->to('/admin/manage-achievements')->with('success', 'Achievement added successfully.');
        }

        // Display add achievement form (GET request)
        return view('admin/add_achievement');
    }


    public function editAchievement($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Get achievement data for editing
        $achievement = $this->achievementModel->find($id);
        if (!$achievement) {
            return redirect()->back()->with('error', 'Achievement not found');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules
            $rules = [
                'title' => 'required|min_length[3]',
                'description' => 'required',
                'level_required' => 'required|integer',
                'category' => 'required',
                'tier' => 'required|in_list[bronze,silver,gold]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/edit_achievement', ['achievement' => $achievement, 'validation' => $this->validator]);
            }

            // Update achievement with validated data
            $this->achievementModel->update($id, [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'image_path' => $this->request->getPost('image_path'),
                'level_required' => $this->request->getPost('level_required'),
                'category' => $this->request->getPost('category'),
                'tier' => $this->request->getPost('tier')
            ]);

            return redirect()->to('/admin/manage-achievements')->with('success', 'Achievement updated successfully.');
        }

        // Display edit achievement form (GET request)
        return view('admin/edit_achievement', ['achievement' => $achievement]);
    }


    public function deleteAchievement($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Delete achievement from database
        $this->achievementModel->delete($id);
        return redirect()->to('/admin/manage-achievements')->with('success', 'Achievement deleted successfully.');
    }

    // ========================================
    // REWARD MANAGEMENT SECTION - FULL CRUD OPERATIONS
    // ========================================
    

    public function manageRewards()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        $rewards = $this->rewardModel->getAllRewards();
        return view('admin/manage_rewards', ['rewards' => $rewards]);
    }


    public function addReward()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules for new reward
            $rules = [
                'name' => 'required|min_length[3]',
                'description' => 'required',
                'cost_ecopoints' => 'required|integer',
                'type' => 'required|in_list[avatar,badge,booster,theme]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/add_reward', ['validation' => $this->validator]);
            }

            // Create new reward with validated data
            $this->rewardModel->insert([
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'image_path' => $this->request->getPost('image_path') ?: '/images/rewards/default.png',
                'cost_ecopoints' => $this->request->getPost('cost_ecopoints'),
                'type' => $this->request->getPost('type'),
                'available' => $this->request->getPost('available') ? 1 : 0
            ]);

            return redirect()->to('/admin/manage-rewards')->with('success', 'Reward added successfully.');
        }

        // Display add reward form (GET request)
        return view('admin/add_reward');
    }


    public function editReward($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Get reward data for editing
        $reward = $this->rewardModel->find($id);
        if (!$reward) {
            return redirect()->back()->with('error', 'Reward not found');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules
            $rules = [
                'name' => 'required|min_length[3]',
                'description' => 'required',
                'cost_ecopoints' => 'required|integer',
                'type' => 'required|in_list[avatar,badge,booster,theme]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/edit_reward', ['reward' => $reward, 'validation' => $this->validator]);
            }

            // Update reward with validated data
            $this->rewardModel->update($id, [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'image_path' => $this->request->getPost('image_path'),
                'cost_ecopoints' => $this->request->getPost('cost_ecopoints'),
                'type' => $this->request->getPost('type'),
                'available' => $this->request->getPost('available') ? 1 : 0
            ]);

            return redirect()->to('/admin/manage-rewards')->with('success', 'Reward updated successfully.');
        }

        // Display edit reward form (GET request)
        return view('admin/edit_reward', ['reward' => $reward]);
    }


    public function deleteReward($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Delete reward from database
        $this->rewardModel->delete($id);
        return redirect()->to('/admin/manage-rewards')->with('success', 'Reward deleted successfully.');
    }

    // ========================================
    // QUEST MANAGEMENT SECTION - FULL CRUD OPERATIONS
    // ========================================
    

    public function manageQuests()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        $quests = $this->questModel->getAllQuests();
        return view('admin/manage_quests', ['quests' => $quests]);
    }


    public function addQuest()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules for new quest
            $rules = [
                'title' => 'required|min_length[3]',
                'description' => 'required',
                'xp_reward' => 'required|integer',
                'ecopoints_reward' => 'required|integer',
                'type' => 'required|in_list[daily,weekly,special]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/add_quest', ['validation' => $this->validator]);
            }

            // Create new quest with validated data
            $this->questModel->insert([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'xp_reward' => $this->request->getPost('xp_reward'),
                'ecopoints_reward' => $this->request->getPost('ecopoints_reward'),
                'type' => $this->request->getPost('type')
            ]);

            return redirect()->to('/admin/manage-quests')->with('success', 'Quest added successfully.');
        }

        // Display add quest form (GET request)
        return view('admin/add_quest');
    }


    public function editQuest($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Get quest data for editing
        $quest = $this->questModel->find($id);
        if (!$quest) {
            return redirect()->back()->with('error', 'Quest not found');
        }

        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Define validation rules
            $rules = [
                'title' => 'required|min_length[3]',
                'description' => 'required',
                'xp_reward' => 'required|integer',
                'ecopoints_reward' => 'required|integer',
                'type' => 'required|in_list[daily,weekly,special]',
            ];

            // Validate input data
            if (!$this->validate($rules)) {
                return view('admin/edit_quest', ['quest' => $quest, 'validation' => $this->validator]);
            }

            // Update quest with validated data
            $this->questModel->update($id, [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'xp_reward' => $this->request->getPost('xp_reward'),
                'ecopoints_reward' => $this->request->getPost('ecopoints_reward'),
                'type' => $this->request->getPost('type')
            ]);

            return redirect()->to('/admin/manage-quests')->with('success', 'Quest updated successfully.');
        }

        // Display edit quest form (GET request)
        return view('admin/edit_quest', ['quest' => $quest]);
    }


    public function deleteQuest($id)
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        // Delete quest from database
        $this->questModel->delete($id);
        return redirect()->to('/admin/manage-quests')->with('success', 'Quest deleted successfully.');
    }

    // ========================================
    // SYSTEM STATISTICS SECTION - READ OPERATIONS
    // ========================================
    

    public function systemStats()
    {
        // Security check
        if (session()->get('userlevel') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        
        // Comprehensive user statistics
        $userStats = [
            'total_users' => $this->model->where('userlevel', 'user')->countAllResults(),
            'active_today' => $db->table('daily_logins')->where('login_date', date('Y-m-d'))->countAllResults(),
            'total_ecopoints' => $db->table('pengguna')->selectSum('ecopoints')->get()->getRow()->ecopoints ?? 0,
            'avg_login_streak' => $db->table('pengguna')->selectAvg('login_streak')->get()->getRow()->login_streak ?? 0
        ];

        // Achievement system statistics
        $achievementStats = [
            'total_achievements' => $this->achievementModel->countAllResults(),
            'total_unlocked' => $db->table('user_achievements')->countAllResults(),
            'bronze_count' => $this->achievementModel->where('tier', 'bronze')->countAllResults(),
            'silver_count' => $this->achievementModel->where('tier', 'silver')->countAllResults(),
            'gold_count' => $this->achievementModel->where('tier', 'gold')->countAllResults()
        ];

        // Reward system statistics
        $rewardStats = [
            'total_rewards' => $this->rewardModel->countAllResults(),
            'total_redeemed' => $db->table('user_rewards')->countAllResults(),
            'available_rewards' => $this->rewardModel->where('available', 1)->countAllResults()
        ];

        // Quest system statistics
        $questStats = [
            'total_quests' => $this->questModel->countAllResults(),
            'accepted_quests' => $db->table('user_quests')->countAllResults(),
            'completed_quests' => $db->table('user_quests')->where('status', 'completed')->countAllResults()
        ];

        return view('admin/system_stats', [
            'userStats' => $userStats,
            'achievementStats' => $achievementStats,
            'rewardStats' => $rewardStats,
            'questStats' => $questStats
        ]);
    }
}

// ========================================
// END OF ADMIN CONTROLLER
// ========================================
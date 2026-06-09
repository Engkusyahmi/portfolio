<?php

use CodeIgniter\Router\RouteCollection;

/**
 * ROUTES CONFIGURATION
 */

// 🌐 Public Pages
$routes->view('/', 'index'); // Main landing page
$routes->view('/mainlayout', 'layout/index'); // Base layout 

// 📄 Dynamic Page Loader
$routes->get('/view/(:segment)', 'Auth::Open/$1');

// 🧪 Test Route
$routes->get('/test', 'Auth::Test'); 

// 🔑 Login Routes
$routes->get('login', 'Auth::login');         // Show login form
$routes->post('login', 'Auth::loginPost');    // Process login submission

// 📝 Register Routes
$routes->get('register', 'Auth::register');       // Show registration form
$routes->post('register', 'Auth::registerPost');  // Process registration submission

// 🚪 Logout Route
$routes->get('logout', 'Auth::logout'); // Log out the user and end session

// ✅ Admin Routes (Protected - for admins only)
$routes->get('/admin', 'Admin::dashboard'); // Admin default dashboard
$routes->get('/admin/dashboard', 'Admin::dashboard'); // Admin dashboard page

// 👥 Admin User Management
$routes->get('/admin/manage-users', 'Admin::manageUsers'); // View all users
$routes->match(['get', 'post'], '/admin/add-user', 'Admin::addUser'); // Add new user 
$routes->match(['get', 'post'], '/admin/edit-user/(:num)', 'Admin::editUser/$1'); // Edit user by ID
$routes->get('/admin/delete-user/(:num)', 'Admin::deleteUser/$1'); // Delete user by ID

// 🏆 Admin Achievement Management
$routes->get('/admin/manage-achievements', 'Admin::manageAchievements'); // View achievements
$routes->match(['get', 'post'], '/admin/add-achievement', 'Admin::addAchievement'); // Add new achievement
$routes->match(['get', 'post'], '/admin/edit-achievement/(:num)', 'Admin::editAchievement/$1'); // Edit achievement by ID
$routes->get('/admin/delete-achievement/(:num)', 'Admin::deleteAchievement/$1'); // Delete achievement by ID

// 🎁 Admin Reward Management
$routes->get('/admin/manage-rewards', 'Admin::manageRewards'); // View rewards
$routes->match(['get', 'post'], '/admin/add-reward', 'Admin::addReward'); // Add new reward
$routes->match(['get', 'post'], '/admin/edit-reward/(:num)', 'Admin::editReward/$1'); // Edit reward by ID
$routes->get('/admin/delete-reward/(:num)', 'Admin::deleteReward/$1'); // Delete reward by ID

// 🧩 Admin Quest Management
$routes->get('/admin/manage-quests', 'Admin::manageQuests'); // View all quests
$routes->match(['get', 'post'], '/admin/add-quest', 'Admin::addQuest'); // Add new quest
$routes->match(['get', 'post'], '/admin/edit-quest/(:num)', 'Admin::editQuest/$1'); // Edit quest by ID
$routes->get('/admin/delete-quest/(:num)', 'Admin::deleteQuest/$1'); // Delete quest by ID

// 📊 Admin Statistics
$routes->get('/admin/system-stats', 'Admin::systemStats'); // Show system stats (users, quests, etc.)

// ✅ User Dashboard (Protected - for logged in users)
$routes->get('/user', 'User::dashboard'); // User main route to dashboard
$routes->get('/user/dashboard', 'User::dashboard'); // Show user dashboard

// ✅ User Feature Pages (Protected)
$routes->get('/user/quest', 'User::quest'); // Show user quests
$routes->get('/user/achievement', 'User::achievement'); // Show user achievements
$routes->get('/user/rewardstore', 'User::rewardStore'); // Show reward store
$routes->get('/user/settings', 'User::settings'); // Show user settings

// ✅ User Actions (Functional and working)
$routes->post('/user/claim-reward', 'User::claimDailyReward'); // Claim daily reward
$routes->post('/user/complete-task', 'User::completeTask'); // Mark a task as completed

// ✅ Quest Actions (Full CRUD functionality)
$routes->post('/user/accept-quest', 'User::acceptQuest');      // Accept a quest 
$routes->post('/user/complete-quest', 'User::completeQuest');  // Complete a quest 
$routes->post('/user/cancel-quest', 'User::cancelQuest');      // Cancel a quest 

// ✅ Other User Actions
$routes->post('/user/redeemReward', 'User::redeemReward'); // Redeem selected reward
$routes->post('/user/updateProfile', 'User::updateProfile'); // Update user profile
$routes->post('/user/updateWater', 'User::updateWater'); // Update water intake data
$routes->post('/user/upgradeSubscription', 'User::upgradeSubscription'); // Upgrade subscription plan
$routes->post('/user/processPayment', 'User::processPayment'); // Handle payment processing
$routes->post('/user/changePassword', 'User::changePassword'); // Change user password

// ✅ User Navigation
$routes->get('/user/leaderboard', 'User::leaderboard'); // Display leaderboard for users

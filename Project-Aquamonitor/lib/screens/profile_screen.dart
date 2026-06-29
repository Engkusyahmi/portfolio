import 'package:flutter/material.dart';
import 'package:aquamonitor/screens/auth_screen.dart';
import 'package:aquamonitor/screens/water_budget_screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:io';
import 'package:image_picker/image_picker.dart';

class ProfileScreen extends StatefulWidget {
  final String userId;
  final String fullname;

  const ProfileScreen({
    super.key,
    required this.userId,
    required this.fullname,
  });

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  late String name;
  String email = "Loading...";
  String phone = "Loading...";
  String? profilePicUrl;
  File? _imageFile;
  bool isLoading = false;

  final ImagePicker _picker = ImagePicker();
  final TextEditingController nameController = TextEditingController();
  final TextEditingController phoneController = TextEditingController();
  final TextEditingController oldPassController = TextEditingController();
  final TextEditingController newPassController = TextEditingController();
  final TextEditingController confirmPassController = TextEditingController();

  @override
  void initState() {
    super.initState();
    name = widget.fullname;
    _fetchUserProfile();
  }

  Future<void> _fetchUserProfile() async {
    try {
      var response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_profile.php?user_id=${widget.userId}'),
      );
      var data = json.decode(response.body);
      if (data['status'] == "success") {
        setState(() {
          name = data['data']['fullname'];
          email = data['data']['email'];
          phone = data['data']['phone'] ?? "No phone added";
          profilePicUrl = data['data']['profile_pic'];
        });
      }
    } catch (e) {
      debugPrint("Error fetching profile: $e");
    }
  }

  void _showImageSourceOptions() {
    showModalBottomSheet(
      context: context,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      builder: (context) => SafeArea(
        child: Wrap(
          children: [
            ListTile(
              leading: const Icon(Icons.camera_alt, color: Color(0xFF003366)),
              title: const Text('Snap Photo (Camera)'),
              onTap: () {
                Navigator.pop(context);
                _pickImage(ImageSource.camera);
              },
            ),
            ListTile(
              leading: const Icon(Icons.photo_library, color: Color(0xFF003366)),
              title: const Text('Choose from Gallery'),
              onTap: () {
                Navigator.pop(context);
                _pickImage(ImageSource.gallery);
              },
            ),
          ],
        ),
      ),
    );
  }

  Future<void> _pickImage(ImageSource source) async {
    try {
      final XFile? pickedFile = await _picker.pickImage(
        source: source,
        maxWidth: 300,
        maxHeight: 300,
        imageQuality: 50,
      );

      if (pickedFile != null) {
        setState(() {
          _imageFile = File(pickedFile.path);
        });
        _updateDatabase();
      }
    } catch (e) {
      debugPrint("Error picking image: $e");
    }
  }

  void _showLogoutConfirmation() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
          title: const Text("Confirm Logout", style: TextStyle(fontWeight: FontWeight.bold)),
          content: const Text("Are you sure you want to logout? Any unsaved changes might be lost."),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text("Cancel", style: TextStyle(color: Colors.grey)),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.redAccent,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
              ),
              onPressed: () {
                Navigator.pop(context);
                Navigator.pushAndRemoveUntil(
                    context,
                    MaterialPageRoute(builder: (context) => const AuthScreen()),
                        (route) => false
                );
              },
              child: const Text("Logout", style: TextStyle(color: Colors.white)),
            ),
          ],
        );
      },
    );
  }

  void _confirmClearHistory() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Clear Water History"),
        content: const Text("Are you sure you want to delete all consumption logs? This action cannot be undone."),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(
              style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
              onPressed: () {
                Navigator.pop(context);
                _clearHistoryFromDB();
              },
              child: const Text("Clear All", style: TextStyle(color: Colors.white))
          ),
        ],
      ),
    );
  }

  Future<void> _clearHistoryFromDB() async {
    setState(() => isLoading = true);
    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/delete_history.php'),
        body: {"user_id": widget.userId},
      );
      var data = json.decode(response.body);
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(data['message'])));
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Server error")));
    }
    setState(() => isLoading = false);
  }

  Future<void> _updateDatabase() async {
    String newName = nameController.text.trim().isEmpty ? name : nameController.text.trim();
    String newPhone = phoneController.text.trim().isEmpty ? phone : phoneController.text.trim();

    setState(() => isLoading = true);
    try {
      var request = http.MultipartRequest(
        'POST',
        Uri.parse('https://078730.unisza.work/webapp/api/updated_profile.php'),
      );

      request.fields['user_id'] = widget.userId;
      request.fields['fullname'] = newName;
      request.fields['phone'] = newPhone;

      if (_imageFile != null) {
        request.files.add(
          await http.MultipartFile.fromPath(
            'image',
            _imageFile!.path,
          ),
        );
      }

      var streamedResponse = await request.send();
      var response = await http.Response.fromStream(streamedResponse);

      if (!response.body.trim().startsWith('{')) {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text("API Error: ${response.body.trim()}")),
          );
        }
        setState(() => isLoading = false);
        return;
      }

      var data = json.decode(response.body);

      if (data['status'] == "success") {
        setState(() {
          name = newName;
          phone = newPhone;
          _imageFile = null;
        });

        await _fetchUserProfile();

        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(data['message'] ?? "Profile updated successfully")),
          );
        }
      } else {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text("Error: ${data['message']}")),
          );
        }
      }
    } catch (e) {
      debugPrint("Multipart Request Error: ${e.toString()}");
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("Server connection error. Please try again.")),
        );
      }
    }
    setState(() => isLoading = false);
  }

  Future<void> _changePassword() async {
    if (newPassController.text != confirmPassController.text) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Passwords do not match!")));
      return;
    }
    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/change_password.php'),
        body: {
          "user_id": widget.userId,
          "old_password": oldPassController.text,
          "new_password": newPassController.text,
        },
      );
      var data = json.decode(response.body);
      if (data['status'] == "success") {
        Navigator.pop(context);
        oldPassController.clear(); newPassController.clear(); confirmPassController.clear();
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Password updated!")));
      } else {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(data['message'])));
      }
    } catch (e) { debugPrint(e.toString()); }
  }

  void _showChangePasswordDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Change Password"),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            TextField(controller: oldPassController, obscureText: true, decoration: const InputDecoration(labelText: "Old Password")),
            TextField(controller: newPassController, obscureText: true, decoration: const InputDecoration(labelText: "New Password")),
            TextField(controller: confirmPassController, obscureText: true, decoration: const InputDecoration(labelText: "Confirm Password")),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(onPressed: _changePassword, child: const Text("Update")),
        ],
      ),
    );
  }

  void _editProfile() {
    nameController.text = name;
    phoneController.text = phone;
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Edit Profile"),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            TextField(controller: nameController, decoration: const InputDecoration(labelText: "Full Name")),
            TextField(controller: phoneController, decoration: const InputDecoration(labelText: "Phone")),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(onPressed: () { Navigator.pop(context); _updateDatabase(); }, child: const Text("Save")),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text("My Profile", style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white, foregroundColor: const Color(0xFF003366),
        elevation: 0, centerTitle: true,
        actions: [IconButton(icon: const Icon(Icons.edit_note, size: 28), onPressed: _editProfile)],
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : SingleChildScrollView(
        padding: const EdgeInsets.all(25),
        child: Column(
          children: [
            Stack(
              children: [
                CircleAvatar(
                  radius: 55,
                  backgroundColor: Colors.grey.shade300,
                  backgroundImage: _imageFile != null
                      ? FileImage(_imageFile!) as ImageProvider
                      : (profilePicUrl != null && profilePicUrl!.isNotEmpty)
                      ? NetworkImage(
                    'https://078730.unisza.work/webapp/api/uploads/$profilePicUrl?v=${DateTime.now().millisecondsSinceEpoch}',
                  )
                      : null,
                  child: (_imageFile == null && (profilePicUrl == null || profilePicUrl!.isEmpty))
                      ? const Icon(Icons.person, size: 70, color: Colors.white)
                      : null,
                ),
                Positioned(
                  bottom: 0,
                  right: 0,
                  child: GestureDetector(
                    onTap: _showImageSourceOptions,
                    child: const CircleAvatar(
                      radius: 18,
                      backgroundColor: Color(0xFF003366),
                      child: Icon(Icons.camera_alt, size: 16, color: Colors.white),
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 15),
            Text(name, style: const TextStyle(fontSize: 22, fontWeight: FontWeight.bold, color: Color(0xFF003366))),
            Text(email, style: const TextStyle(color: Colors.grey, fontSize: 16)),
            const SizedBox(height: 30),

            _profileTile(Icons.phone_iphone, "Phone Number", phone),
            _profileTile(Icons.lock_outline, "Security", "Change Password", onTap: _showChangePasswordDialog),
            _profileTile(
                Icons.settings_suggest_outlined,
                "Water Settings",
                "Budget & Alert Threshold",
                onTap: () => Navigator.push(context, MaterialPageRoute(builder: (context) => WaterBudgetScreen(userId: widget.userId)))
            ),
            _profileTile(
                Icons.delete_sweep_outlined,
                "Data Management",
                "Clear Consumption History",
                onTap: _confirmClearHistory
            ),
            _profileTile(Icons.verified_user_outlined, "Account Status", "Verified"),

            const SizedBox(height: 50),
            SizedBox(
              width: double.infinity, height: 50,
              child: ElevatedButton.icon(
                onPressed: _showLogoutConfirmation,
                icon: const Icon(Icons.logout),
                label: const Text("LOGOUT"),
                style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.redAccent,
                    foregroundColor: Colors.white,
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _profileTile(IconData icon, String title, String value, {VoidCallback? onTap}) {
    return Container(
      margin: const EdgeInsets.only(bottom: 15),
      decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(15),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.03), blurRadius: 10)]
      ),
      child: ListTile(
        onTap: onTap,
        leading: Icon(icon, color: Colors.blue.shade700),
        title: Text(title, style: const TextStyle(fontSize: 13, color: Colors.grey)),
        subtitle: Text(value, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: Colors.black87)),
        trailing: onTap != null ? const Icon(Icons.arrow_forward_ios, size: 14) : null,
      ),
    );
  }
}
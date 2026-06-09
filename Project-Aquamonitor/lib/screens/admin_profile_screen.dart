import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class AdminProfileScreen extends StatefulWidget {
  final Map<String, dynamic> adminData;

  const AdminProfileScreen({super.key, required this.adminData});

  @override
  State<AdminProfileScreen> createState() => _AdminProfileScreenState();
}

class _AdminProfileScreenState extends State<AdminProfileScreen> {
  final _oldPasswordController = TextEditingController();
  final _newPasswordController = TextEditingController();

  // FUNGSI API CALL
  Future<void> _updatePassword(String oldPass, String newPass) async {
    try {
      // Guna URL yang sama dengan user biasa sebab logic dia sama (verify old, hash new)
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/change_password.php'),
        body: {
          "user_id": widget.adminData['id'].toString(),
          "old_password": oldPass,
          "new_password": newPass,
        },
      ).timeout(const Duration(seconds: 10));

      var data = json.decode(response.body);

      if (data['status'] == 'success') {
        if (!mounted) return;
        _showSnackBar(data['message'], Colors.green);
        _oldPasswordController.clear();
        _newPasswordController.clear();
      } else {
        _showSnackBar(data['message'], Colors.red);
      }
    } catch (e) {
      _showSnackBar("Connection Error: $e", Colors.red);
    }
  }

  void _showSnackBar(String msg, Color color) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(msg), backgroundColor: color),
    );
  }

  // DIALOG POPUP
  void _showChangePasswordDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: const Text("Change Admin Password"),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            TextField(
              controller: _oldPasswordController,
              obscureText: true,
              decoration: const InputDecoration(labelText: "Old Password"),
            ),
            const SizedBox(height: 10),
            TextField(
              controller: _newPasswordController,
              obscureText: true,
              decoration: const InputDecoration(labelText: "New Password"),
            ),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(
            onPressed: () {
              if (_oldPasswordController.text.isNotEmpty && _newPasswordController.text.length >= 6) {
                _updatePassword(_oldPasswordController.text, _newPasswordController.text);
                Navigator.pop(context);
              } else {
                _showSnackBar("Please fill all fields (Min 6 chars for new password)", Colors.orange);
              }
            },
            child: const Text("Update Now"),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7FA),
      appBar: AppBar(
        title: const Text("Admin Security"),
        backgroundColor: Colors.blue.shade900,
        foregroundColor: Colors.white,
        elevation: 0,
      ),
      body: Column(
        children: [
          Container(
            width: double.infinity,
            padding: const EdgeInsets.all(30),
            decoration: BoxDecoration(
              color: Colors.blue.shade900,
              borderRadius: const BorderRadius.vertical(bottom: Radius.circular(30)),
            ),
            child: Column(
              children: [
                const CircleAvatar(
                  radius: 45,
                  backgroundColor: Colors.white24,
                  child: Icon(Icons.shield, size: 45, color: Colors.white),
                ),
                const SizedBox(height: 15),
                Text(widget.adminData['fullname'] ?? "Admin",
                    style: const TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.bold)),
                Text(widget.adminData['email'] ?? "", style: const TextStyle(color: Colors.white70)),
              ],
            ),
          ),
          const SizedBox(height: 20),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: Card(
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
              child: Column(
                children: [
                  ListTile(
                    leading: const Icon(Icons.person_outline, color: Colors.blue),
                    title: const Text("Account Role"),
                    trailing: Text(widget.adminData['role'].toString().toUpperCase(),
                        style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.blue)),
                  ),
                  const Divider(height: 1),
                  ListTile(
                    leading: const Icon(Icons.lock_outline, color: Colors.orange),
                    title: const Text("Password Management"),
                    subtitle: const Text("Change your secret password"),
                    trailing: const Icon(Icons.arrow_forward_ios, size: 14),
                    onTap: () => _showChangePasswordDialog(),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
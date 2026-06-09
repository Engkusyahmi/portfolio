import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'main_wrapper.dart';
import 'admin_dashboard.dart';

class AuthScreen extends StatefulWidget {
  const AuthScreen({super.key});

  @override
  State<AuthScreen> createState() => _AuthScreenState();
}

class _AuthScreenState extends State<AuthScreen> with SingleTickerProviderStateMixin {
  late TabController _tabController;

  final TextEditingController loginEmailController = TextEditingController();
  final TextEditingController loginPasswordController = TextEditingController();

  final TextEditingController regNameController = TextEditingController();
  final TextEditingController regEmailController = TextEditingController();
  final TextEditingController regPhoneController = TextEditingController();
  final TextEditingController regPasswordController = TextEditingController();

  bool _isLoading = false;
  bool _isPasswordVisible = false;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 2, vsync: this);
  }

  Future<void> loginUser() async {
    if (loginEmailController.text.isEmpty || loginPasswordController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Sila isi semua ruangan")));
      return;
    }

    setState(() => _isLoading = true);
    var url = Uri.parse('https://078730.unisza.work/webapp/api/login.php');

    try {
      var response = await http.post(url, body: {
        "email": loginEmailController.text.trim(),
        "password": loginPasswordController.text.trim()
      });

      var data = json.decode(response.body);

      if (data['status'] == "success") {
        var userData = data['user'];
        String role = userData['role']?.toString().toLowerCase() ?? 'user';

        if (!mounted) return;

        if (role == 'admin') {
          // UPDATE: Hantar data userId, fullname, dan email ke Admin Dashboard
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => AdminDashboard(
                userId: userData['id'].toString(),
                fullname: userData['fullname'] ?? "Admin",
                email: userData['email'] ?? "admin@aquamonitor.com",
              ),
            ),
          );
        } else {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => MainWrapper(
                userId: userData['id'].toString(),
                fullname: userData['fullname'] ?? "User",
                deviceId: userData['device_id']?.toString() ?? "",
              ),
            ),
          );
        }
      } else {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(data['message'])));
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text("Error: $e")));
    } finally {
      if (mounted) setState(() => _isLoading = false);
    }
  }

  Future<void> registerUser() async {
    if (regNameController.text.isEmpty || regEmailController.text.isEmpty || regPasswordController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Please fill all fields!")));
      return;
    }

    setState(() => _isLoading = true);
    var url = Uri.parse('https://078730.unisza.work/webapp/api/register.php');

    try {
      var response = await http.post(url, body: {
        "fullname": regNameController.text,
        "email": regEmailController.text,
        "phone": regPhoneController.text,
        "password": regPasswordController.text,
      });

      var data = json.decode(response.body);

      if (data['status'] == "success") {
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Berjaya Daftar! Silalah Login.")));
        _tabController.animateTo(0);
      } else {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text("Gagal: ${data['message']}")));
      }
    } catch (e) {
      print("Error: $e");
    } finally {
      if (mounted) setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF3F9FF),
      body: SingleChildScrollView(
        child: Column(
          children: [
            const SizedBox(height: 70),
            const Icon(Icons.water_drop, size: 80, color: Colors.blue),
            const Text("AquaMonitor", style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold, color: Color(0xFF003366))),
            const Text("Smart Water Management", style: TextStyle(color: Colors.blueGrey)),
            const SizedBox(height: 40),

            Container(
              margin: const EdgeInsets.symmetric(horizontal: 25),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(20),
                boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 15)],
              ),
              child: Column(
                children: [
                  TabBar(
                    controller: _tabController,
                    indicatorColor: Colors.blue,
                    labelColor: Colors.blue,
                    unselectedLabelColor: Colors.grey,
                    tabs: const [
                      Tab(text: "LOGIN"),
                      Tab(text: "SIGN UP"),
                    ],
                  ),
                  SizedBox(
                    height: 480,
                    child: TabBarView(
                      controller: _tabController,
                      children: [
                        _buildLoginForm(),
                        _buildRegisterForm(),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }

  Widget _buildLoginForm() {
    return Padding(
      padding: const EdgeInsets.all(25),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildLabel("Email"),
          _buildTextField(hint: "example@gmail.com", icon: Icons.email_outlined, controller: loginEmailController),
          const SizedBox(height: 20),
          _buildLabel("Password"),
          _buildPasswordField(controller: loginPasswordController),
          const SizedBox(height: 40),
          SizedBox(
            width: double.infinity,
            height: 55,
            child: ElevatedButton(
              onPressed: _isLoading ? null : loginUser,
              style: ElevatedButton.styleFrom(backgroundColor: Colors.blue, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))),
              child: _isLoading ? const CircularProgressIndicator(color: Colors.white) : const Text("LOGIN", style: TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildRegisterForm() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(25),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildLabel("Full Name"),
          _buildTextField(hint: "John Doe", icon: Icons.person_outline, controller: regNameController),
          const SizedBox(height: 15),
          _buildLabel("Email"),
          _buildTextField(hint: "example@gmail.com", icon: Icons.email_outlined, controller: regEmailController),
          const SizedBox(height: 15),
          _buildLabel("Phone"),
          _buildTextField(hint: "0123456789", icon: Icons.phone_android, controller: regPhoneController),
          const SizedBox(height: 15),
          _buildLabel("Password"),
          _buildPasswordField(controller: regPasswordController),
          const SizedBox(height: 30),
          SizedBox(
            width: double.infinity,
            height: 55,
            child: ElevatedButton(
              onPressed: _isLoading ? null : registerUser,
              style: ElevatedButton.styleFrom(backgroundColor: Colors.blue, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))),
              child: _isLoading ? const CircularProgressIndicator(color: Colors.white) : const Text("SIGN UP", style: TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLabel(String text) {
    return Padding(padding: const EdgeInsets.only(bottom: 8), child: Text(text, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14)));
  }

  Widget _buildTextField({required String hint, required IconData icon, required TextEditingController controller}) {
    return TextField(
      controller: controller,
      decoration: InputDecoration(
        prefixIcon: Icon(icon, color: Colors.blue, size: 20),
        hintText: hint,
        filled: true,
        fillColor: Colors.grey.shade50,
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide(color: Colors.grey.shade300)),
        enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide(color: Colors.grey.shade200)),
      ),
    );
  }

  Widget _buildPasswordField({required TextEditingController controller}) {
    return TextField(
      controller: controller,
      obscureText: !_isPasswordVisible,
      decoration: InputDecoration(
        prefixIcon: const Icon(Icons.lock_outline, color: Colors.blue, size: 20),
        hintText: "Enter password",
        filled: true,
        fillColor: Colors.grey.shade50,
        suffixIcon: IconButton(
          icon: Icon(_isPasswordVisible ? Icons.visibility : Icons.visibility_off, color: Colors.grey),
          onPressed: () => setState(() => _isPasswordVisible = !_isPasswordVisible),
        ),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide(color: Colors.grey.shade300)),
        enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide(color: Colors.grey.shade200)),
      ),
    );
  }
}
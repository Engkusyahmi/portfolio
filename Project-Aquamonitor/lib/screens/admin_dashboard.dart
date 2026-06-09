import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:aquamonitor/screens/auth_screen.dart';
import 'package:aquamonitor/screens/admin_profile_screen.dart';

class AdminDashboard extends StatefulWidget {
  final String userId;
  final String fullname;
  final String email;

  const AdminDashboard({
    super.key,
    required this.userId,
    required this.fullname,
    required this.email,
  });

  @override
  State<AdminDashboard> createState() => _AdminDashboardState();
}

class _AdminDashboardState extends State<AdminDashboard> {
  // 1. Ambil data dari PHP
  Future<Map<String, dynamic>> fetchAdminData() async {
    try {
      var res = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/admin_get_all.php'),
      ).timeout(const Duration(seconds: 10));

      if (res.statusCode == 200) {
        debugPrint("Data Received: ${res.body}");
        return json.decode(res.body);
      } else {
        throw Exception("Server Error: ${res.statusCode}");
      }
    } catch (e) {
      throw Exception("Connection error: $e");
    }
  }

  // ---------------------------------------------------------
  // SECTION: HISTORY CATEGORY CRUD (THRESHOLD)
  // ---------------------------------------------------------

  Future<void> _manageThreshold(String action, String key, String value) async {
    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/admin_manage_thresholds.php'),
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: {
          "action": action,
          "setting_key": key,
          "setting_value": value,
        },
      );
      if (response.statusCode == 200) {
        setState(() {}); // Refresh UI
        if (!mounted) return;
        ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(backgroundColor: Colors.green, content: Text("Category Rule $action successful!"))
        );
      }
    } catch (e) {
      debugPrint("Threshold Error: $e");
    }
  }

  void _showThresholdDialog({Map? existingData}) {
    final keyController = TextEditingController(text: existingData?['setting_key'] ?? "");
    final valController = TextEditingController(text: existingData?['setting_value']?.toString() ?? "");
    bool isEdit = existingData != null;

    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: Text(isEdit ? "Edit Usage Rule" : "New Usage Rule"),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Text("Define limits for History (Eco/Normal/High)",
                style: TextStyle(fontSize: 12, color: Colors.grey)),
            const SizedBox(height: 15),
            TextField(
              controller: keyController,
              enabled: !isEdit,
              decoration: const InputDecoration(
                  labelText: "Rule Key",
                  hintText: "e.g., eco_limit or high_limit",
                  border: OutlineInputBorder()
              ),
            ),
            const SizedBox(height: 15),
            TextField(
              controller: valController,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                  labelText: "Limit Value (Liters)",
                  suffixText: "L",
                  border: OutlineInputBorder()
              ),
            ),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(
            onPressed: () {
              if (keyController.text.isNotEmpty && valController.text.isNotEmpty) {
                _manageThreshold(isEdit ? "update" : "create", keyController.text, valController.text);
                Navigator.pop(context);
              }
            },
            child: Text(isEdit ? "Update Rule" : "Create Rule"),
          ),
        ],
      ),
    );
  }

  // ---------------------------------------------------------
  // SECTION: ALERT FUNCTIONS (CRUD)
  // ---------------------------------------------------------

  Future<void> _submitAlert(String title, String message, String type, String targetId) async {
    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/create_alert.php'),
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: {
          "title": title.trim(),
          "message": message.trim(),
          "alert_type": type,
          "target_user_id": targetId.trim(),
          "created_by": widget.userId,
        },
      );
      if (response.statusCode == 200) {
        setState(() {});
        if (!mounted) return;
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(backgroundColor: Colors.green, content: Text("Alert Sent!")));
      }
    } catch (e) {
      debugPrint("Error: $e");
    }
  }

  Future<void> _deleteAlert(String id) async {
    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/delete_alert.php'),
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: {"id": id},
      );
      if (response.statusCode == 200) {
        setState(() {});
        if (!mounted) return;
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Alert deleted")));
      }
    } catch (e) {
      debugPrint("Delete error: $e");
    }
  }

  void _showEditAlertModule(Map alertData) {
    final titleController = TextEditingController(text: alertData['title']);
    final msgController = TextEditingController(text: alertData['message']);
    final targetIdController = TextEditingController(text: alertData['user_id']?.toString() ?? "");
    String selectedType = alertData['alert_type'] ?? 'info';

    showDialog(
      context: context,
      builder: (context) => StatefulBuilder(
        builder: (context, setModalState) => AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
          title: const Text("Edit Alert Message"),
          content: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                TextField(controller: targetIdController, decoration: const InputDecoration(labelText: "Target User ID")),
                TextField(controller: titleController, decoration: const InputDecoration(labelText: "Alert Title")),
                TextField(controller: msgController, maxLines: 3, decoration: const InputDecoration(labelText: "Alert Message")),
                DropdownButtonFormField<String>(
                  value: selectedType,
                  items: const [
                    DropdownMenuItem(value: 'info', child: Text("Info")),
                    DropdownMenuItem(value: 'warning', child: Text("Warning")),
                    DropdownMenuItem(value: 'danger', child: Text("Danger")),
                  ],
                  onChanged: (val) => setModalState(() => selectedType = val!),
                ),
              ],
            ),
          ),
          actions: [
            TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
            ElevatedButton(
              onPressed: () async {
                await http.post(
                  Uri.parse('https://078730.unisza.work/webapp/api/edit_alert.php'),
                  headers: {"Content-Type": "application/x-www-form-urlencoded"},
                  body: {
                    "id": alertData['id'].toString(),
                    "title": titleController.text,
                    "message": msgController.text,
                    "alert_type": selectedType,
                    "target_user_id": targetIdController.text,
                  },
                );
                if (!mounted) return;
                Navigator.pop(context);
                setState(() {});
              },
              child: const Text("Update"),
            ),
          ],
        ),
      ),
    );
  }

  // ---------------------------------------------------------
  // SECTION: USER MANAGEMENT FUNCTIONS
  // ---------------------------------------------------------

  void _showEditUserDialog(Map user) {
    final deviceController = TextEditingController(text: user['device_id']);
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: Text("Edit Device for ${user['fullname']}"),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Text("Update hardware ID for this user:", style: TextStyle(fontSize: 12, color: Colors.grey)),
            const SizedBox(height: 15),
            TextField(
              controller: deviceController,
              decoration: const InputDecoration(
                labelText: "Device ID",
                border: OutlineInputBorder(),
                prefixIcon: Icon(Icons.router),
              ),
            ),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(
            onPressed: () async {
              var response = await http.post(
                Uri.parse('https://078730.unisza.work/webapp/api/admin_manage_user.php'),
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: {
                  "action": "update",
                  "user_id": user['id'].toString(),
                  "device_id": deviceController.text.trim(),
                },
              );
              if (response.statusCode == 200) {
                if (!mounted) return;
                Navigator.pop(context);
                setState(() {});
                ScaffoldMessenger.of(context).showSnackBar(const SnackBar(backgroundColor: Colors.green, content: Text("User Updated!")));
              }
            },
            child: const Text("Update Device"),
          ),
        ],
      ),
    );
  }

  void _confirmDeleteUser(String? id) {
    if (id == null || id == "null") return;
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: const Text("Delete User?"),
        content: const Text("Are you sure? All data for this user will be permanently deleted."),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: Colors.redAccent),
            onPressed: () async {
              var response = await http.post(
                Uri.parse('https://078730.unisza.work/webapp/api/admin_manage_user.php'),
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: {"action": "delete", "user_id": id},
              );
              if (response.statusCode == 200) {
                if (!mounted) return;
                Navigator.pop(context);
                setState(() {});
              }
            },
            child: const Text("Delete", style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }

  // ---------------------------------------------------------
  // SECTION: MISC FUNCTIONS
  // ---------------------------------------------------------

  void _confirmLogout() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: const Text("Confirm Logout"),
        content: const Text("Are you sure you want to sign out?"),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: Colors.redAccent),
            onPressed: () {
              Navigator.pop(context);
              Navigator.pushAndRemoveUntil(context, MaterialPageRoute(builder: (context) => const AuthScreen()), (route) => false);
            },
            child: const Text("Logout", style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }

  void _showAdminProfile() {
    showModalBottomSheet(
      context: context,
      shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(20))),
      builder: (context) => Padding(
        padding: const EdgeInsets.all(25),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const CircleAvatar(radius: 40, backgroundColor: Colors.blue, child: Icon(Icons.admin_panel_settings, color: Colors.white, size: 40)),
            const SizedBox(height: 15),
            Text(widget.fullname, style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
            Text(widget.email, style: const TextStyle(color: Colors.grey)),
            const Divider(height: 30),
            ListTile(
              leading: const Icon(Icons.lock_reset, color: Colors.orange),
              title: const Text("Change Admin Password"),
              onTap: () {
                Navigator.pop(context);
                Navigator.push(context, MaterialPageRoute(builder: (context) => AdminProfileScreen(adminData: {'id': widget.userId, 'fullname': widget.fullname, 'email': widget.email, 'role': 'admin'})));
              },
            ),
          ],
        ),
      ),
    );
  }

  void _showCreateAlertModule() {
    final titleController = TextEditingController();
    final msgController = TextEditingController();
    final targetIdController = TextEditingController();
    String selectedType = 'info';

    showDialog(
      context: context,
      builder: (context) => StatefulBuilder(
        builder: (context, setModalState) => AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
          title: const Text("New Alert Message"),
          content: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                TextField(controller: targetIdController, decoration: const InputDecoration(labelText: "Target User ID", hintText: "Leave blank for Broadcast", prefixIcon: Icon(Icons.person_pin, size: 20)), keyboardType: TextInputType.number),
                const SizedBox(height: 10),
                TextField(controller: titleController, decoration: const InputDecoration(labelText: "Alert Title")),
                const SizedBox(height: 10),
                TextField(controller: msgController, maxLines: 3, decoration: const InputDecoration(labelText: "Alert Message")),
                const SizedBox(height: 15),
                DropdownButtonFormField<String>(
                  value: selectedType,
                  decoration: const InputDecoration(labelText: "Urgency Level"),
                  items: const [
                    DropdownMenuItem(value: 'info', child: Text("Info (Blue)")),
                    DropdownMenuItem(value: 'warning', child: Text("Warning (Orange)")),
                    DropdownMenuItem(value: 'danger', child: Text("Danger (Red)")),
                  ],
                  onChanged: (val) => setModalState(() => selectedType = val!),
                ),
              ],
            ),
          ),
          actions: [
            TextButton(onPressed: () => Navigator.pop(context), child: const Text("Cancel")),
            ElevatedButton(
              onPressed: () {
                if (titleController.text.isNotEmpty) {
                  _submitAlert(titleController.text, msgController.text, selectedType, targetIdController.text);
                  Navigator.pop(context);
                }
              },
              child: const Text("Send"),
            ),
          ],
        ),
      ),
    );
  }

  // ---------------------------------------------------------
  // BUILD METHOD (UI)
  // ---------------------------------------------------------

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7FA),
      appBar: _buildAppBar(context),
      body: FutureBuilder<Map<String, dynamic>>(
        future: fetchAdminData(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) return const Center(child: CircularProgressIndicator());
          if (snapshot.hasError) return Center(child: Text("Error: ${snapshot.error}"));
          if (!snapshot.hasData) return const Center(child: Text("No data found"));

          var data = snapshot.data!;
          var stats = data['stats'] ?? {};
          var users = data['users'] as List? ?? [];
          var logs = data['logs'] as List? ?? [];
          var alerts = data['alerts'] as List? ?? [];
          var settings = data['settings'] as List? ?? [];

          return RefreshIndicator(
            onRefresh: () async => setState(() {}),
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text("Admin Dashboard", style: TextStyle(fontSize: 28, fontWeight: FontWeight.bold, color: Color(0xFF003366))),
                  const Text("Manage usage categories & monitoring", style: TextStyle(color: Colors.grey)),
                  const SizedBox(height: 25),

                  // --- WIDGET CRUD: HISTORY CATEGORY LIMITS ---
                  _buildSectionHeader(Icons.history_edu, "History Category Thresholds"),
                  const SizedBox(height: 5),
                  const Text("Set limits for Eco and High Usage in History Screen", style: TextStyle(fontSize: 10, color: Colors.blueGrey)),
                  const SizedBox(height: 10),
                  _buildThresholdList(settings),
                  const SizedBox(height: 30),

                  Row(children: [
                    Expanded(child: _buildStatCard("Users", "${stats['users']}", "Registered", Icons.people, Colors.blue)),
                    const SizedBox(width: 10),
                    Expanded(child: _buildStatCard("Devices", "${stats['devices']}", "Active IoT", Icons.sensors, Colors.green)),
                  ]),
                  const SizedBox(height: 10),
                  _buildStatCard("Data Logs", "${stats['data_points']}", "Total records in DB", Icons.storage, Colors.purple),
                  const SizedBox(height: 30),
                  _buildSectionHeader(Icons.group, "User Management"),
                  const SizedBox(height: 15),
                  _buildUserTable(users),
                  const SizedBox(height: 30),
                  _buildSectionHeader(Icons.analytics_outlined, "Recent System Logs"),
                  const SizedBox(height: 15),
                  _buildDataLogsTable(logs),
                  const SizedBox(height: 30),
                  Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
                    _buildSectionHeader(Icons.notifications_active_outlined, "System Alerts"),
                    ElevatedButton.icon(onPressed: () => _showCreateAlertModule(), icon: const Icon(Icons.add), label: const Text("Create Alert"), style: ElevatedButton.styleFrom(backgroundColor: Colors.blue, foregroundColor: Colors.white)),
                  ]),
                  const SizedBox(height: 15),
                  if (alerts.isEmpty) const Center(child: Text("No recent alerts"))
                  else Column(children: alerts.map((a) => _buildAlertBox(a)).toList()),
                ],
              ),
            ),
          );
        },
      ),
    );
  }

  // --- UI HELPER WIDGETS ---

  // FUNGSI BARU: Untuk tentukan warna secara dinamik ikut KEY
  Color getRuleColor(String key) {
    String k = key.toLowerCase();
    if (k.contains('eco')) return Colors.green;
    if (k.contains('high')) return Colors.red;
    if (k.contains('normal')) return Colors.blue; // WARNA BIRU UNTUK NORMAL
    return Colors.grey;
  }

  Widget _buildThresholdList(List settings) {
    return Container(
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.grey.shade200)),
      child: Column(
        children: [
          ...settings.map((s) {
            Color itemColor = getRuleColor(s['setting_key'].toString());
            return ListTile(
              leading: CircleAvatar(
                  backgroundColor: itemColor.withOpacity(0.1),
                  child: Icon(Icons.label_important_outline,
                      color: itemColor, size: 20)
              ),
              title: Text(s['setting_key']?.toString().replaceAll('_', ' ').toUpperCase() ?? "",
                  style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13)),
              subtitle: Text("Label changes at ${s['setting_value']} Liters", style: const TextStyle(fontSize: 12)),
              trailing: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  IconButton(icon: const Icon(Icons.edit, size: 20, color: Colors.blueGrey), onPressed: () => _showThresholdDialog(existingData: s)),
                  IconButton(icon: const Icon(Icons.delete_outline, size: 20, color: Colors.redAccent), onPressed: () => _manageThreshold("delete", s['setting_key'], "0")),
                ],
              ),
            );
          }),
          ListTile(
            onTap: () => _showThresholdDialog(),
            leading: const Icon(Icons.add_circle_outline, color: Colors.blue),
            title: const Text("Add New Usage Rule", style: TextStyle(color: Colors.blue, fontWeight: FontWeight.bold, fontSize: 13)),
          )
        ],
      ),
    );
  }

  AppBar _buildAppBar(BuildContext context) {
    return AppBar(
      backgroundColor: Colors.white,
      elevation: 0.5,
      title: const Text("AquaMonitor Admin", style: TextStyle(color: Color(0xFF003366), fontWeight: FontWeight.bold)),
      actions: [
        GestureDetector(
          onTap: () => _showAdminProfile(),
          child: Container(
            margin: const EdgeInsets.symmetric(vertical: 10, horizontal: 10),
            padding: const EdgeInsets.symmetric(horizontal: 15),
            decoration: BoxDecoration(color: Colors.blue.shade50, borderRadius: BorderRadius.circular(20)),
            child: Center(child: Text("admin: ${widget.fullname}", style: const TextStyle(color: Colors.blue, fontWeight: FontWeight.bold, fontSize: 12))),
          ),
        ),
        IconButton(icon: const Icon(Icons.logout, color: Colors.red), onPressed: _confirmLogout),
      ],
    );
  }

  Widget _buildStatCard(String title, String value, String sub, IconData icon, Color color) {
    return Container(
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.grey.shade200)),
      child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
        Icon(icon, color: color, size: 20),
        const SizedBox(height: 8),
        Text(value, style: const TextStyle(fontSize: 22, fontWeight: FontWeight.bold)),
        Text(title, style: const TextStyle(color: Colors.grey, fontSize: 11)),
        Text(sub, style: TextStyle(color: color, fontSize: 9, fontWeight: FontWeight.bold)),
      ]),
    );
  }

  Widget _buildUserTable(List users) {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        child: DataTable(
          columns: const [
            DataColumn(label: Text('User')),
            DataColumn(label: Text('Device ID')),
            DataColumn(label: Text('Action')),
          ],
          rows: users.map<DataRow>((u) => DataRow(cells: [
            DataCell(Text(u['fullname'] ?? "-")),
            DataCell(Text(u['device_id'] ?? "No Device")),
            DataCell(
              Row(
                children: [
                  IconButton(
                      icon: const Icon(Icons.edit, color: Colors.blue, size: 18),
                      onPressed: () => _showEditUserDialog(u)
                  ),
                  IconButton(
                      icon: const Icon(Icons.delete_outline, color: Colors.redAccent, size: 18),
                      onPressed: () => _confirmDeleteUser(u['id']?.toString())
                  ),
                ],
              ),
            ),
          ])).toList(),
        ),
      ),
    );
  }

  Widget _buildDataLogsTable(List logs) {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        child: DataTable(
          columns: const [DataColumn(label: Text('Time Recorded')), DataColumn(label: Text('Usage (L)'))],
          rows: logs.take(5).map<DataRow>((l) => DataRow(cells: [
            DataCell(Text(l['recorded_at'].toString())),
            DataCell(Text(l['total_consumption'].toString())),
          ])).toList(),
        ),
      ),
    );
  }

  Widget _buildAlertBox(Map a) {
    Color color = a['alert_type'] == 'danger' ? Colors.red : (a['alert_type'] == 'warning' ? Colors.orange : Colors.blue);
    return Container(
      margin: const EdgeInsets.only(bottom: 8),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(color: color.withOpacity(0.05), borderRadius: BorderRadius.circular(10), border: Border.all(color: color.withOpacity(0.2))),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(a['title'] ?? "", style: TextStyle(fontWeight: FontWeight.bold, color: color)),
              Row(
                children: [
                  IconButton(icon: const Icon(Icons.edit, size: 16, color: Colors.blueGrey), onPressed: () => _showEditAlertModule(a)),
                  IconButton(icon: const Icon(Icons.delete_outline, size: 16, color: Colors.redAccent), onPressed: () => _deleteAlert(a['id'].toString())),
                ],
              ),
            ],
          ),
          Text(a['message'] ?? "", style: const TextStyle(fontSize: 12)),
          const SizedBox(height: 5),
          Text(a['created_at'] ?? "", style: const TextStyle(fontSize: 10, color: Colors.grey)),
        ],
      ),
    );
  }

  Widget _buildSectionHeader(IconData icon, String title) {
    return Row(
      children: [
        Icon(icon, color: Colors.blue, size: 18),
        const SizedBox(width: 8),
        Text(title, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
      ],
    );
  }
}
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class NotificationScreen extends StatefulWidget {
  final String userId;
  const NotificationScreen({super.key, required this.userId});

  @override
  State<NotificationScreen> createState() => _NotificationScreenState();
}

class _NotificationScreenState extends State<NotificationScreen> {

  Future<List> _fetchAlerts() async {
    try {
      final response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_alerts.php?user_id=${widget.userId}'),
      ).timeout(const Duration(seconds: 10));

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        return [];
      }
    } catch (e) {
      debugPrint("Error fetch: $e");
      return [];
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text("Notifications", style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF003366),
        elevation: 0.5,
        centerTitle: true,
      ),
      body: FutureBuilder<List>(
        future: _fetchAlerts(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError || !snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.notifications_off_outlined, size: 60, color: Colors.grey.shade400),
                  const SizedBox(height: 10),
                  const Text("No notifications yet.", style: TextStyle(color: Colors.grey)),
                ],
              ),
            );
          }

          return RefreshIndicator(
            onRefresh: () async => setState(() {}),
            child: ListView.builder(
              padding: const EdgeInsets.all(15),
              itemCount: snapshot.data!.length,
              itemBuilder: (context, index) {
                var alert = snapshot.data![index];
                Color alertColor = alert['alert_type'] == 'danger'
                    ? Colors.red
                    : (alert['alert_type'] == 'warning' ? Colors.orange : Colors.blue);

                return Container(
                  margin: const EdgeInsets.only(bottom: 12),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(12),
                    border: Border(left: BorderSide(color: alertColor, width: 5)),
                    boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.03), blurRadius: 5)],
                  ),
                  child: ListTile(
                    contentPadding: const EdgeInsets.symmetric(horizontal: 15, vertical: 10),
                    leading: CircleAvatar(
                      backgroundColor: alertColor.withOpacity(0.1),
                      child: Icon(
                        alert['alert_type'] == 'danger' ? Icons.priority_high : Icons.info_outline,
                        color: alertColor,
                      ),
                    ),
                    title: Text(
                      alert['title'] ?? "No Title",
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                    ),
                    subtitle: Padding(
                      padding: const EdgeInsets.only(top: 5),
                      child: Text(alert['message'] ?? ""),
                    ),
                    trailing: Text(
                      alert['created_at'].toString().split(' ')[0], // Ambil tarikh saja
                      style: const TextStyle(fontSize: 10, color: Colors.grey),
                    ),
                  ),
                );
              },
            ),
          );
        },
      ),
    );
  }
}
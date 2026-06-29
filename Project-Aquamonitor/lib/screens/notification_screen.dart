import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class NotificationScreen extends StatefulWidget {
  final String userId;

  const NotificationScreen({
    super.key,
    required this.userId,
  });

  @override
  State<NotificationScreen> createState() =>
      _NotificationScreenState();
}

class _NotificationScreenState
    extends State<NotificationScreen> {

  late Future<List> futureAlerts;

  @override
  void initState() {
    super.initState();
    futureAlerts = _fetchAlerts();
  }

  Future<List> _fetchAlerts() async {
    try {
      final response = await http.get(
        Uri.parse(
          'https://078730.unisza.work/webapp/api/get_alerts.php?user_id=${widget.userId}',
        ),
      ).timeout(const Duration(seconds: 10));

      if (response.statusCode == 200) {
        return json.decode(response.body);
      }

      return [];

    } catch (e) {
      debugPrint("Fetch Error: $e");
      return [];
    }
  }

  Future<void> _markAsRead(String id) async {
    try {
      await http.post(
        Uri.parse(
          'https://078730.unisza.work/webapp/api/mark_notification_read.php',
        ),
        body: {
          "id": id,
        },
      );
    } catch (e) {
      debugPrint("Mark Read Error: $e");
    }
  }

  Future<void> _refresh() async {
    setState(() {
      futureAlerts = _fetchAlerts();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),

      appBar: AppBar(
        title: const Text(
          "Notifications",
          style: TextStyle(
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF003366),
        elevation: 0.5,
        centerTitle: true,
      ),

      body: FutureBuilder<List>(
        future: futureAlerts,

        builder: (context, snapshot) {

          if (snapshot.connectionState ==
              ConnectionState.waiting) {

            return const Center(
              child: CircularProgressIndicator(),
            );
          }

          if (!snapshot.hasData ||
              snapshot.data == null ||
              snapshot.data!.isEmpty) {

            return Center(
              child: Column(
                mainAxisAlignment:
                MainAxisAlignment.center,
                children: [
                  Icon(
                    Icons.notifications_off_outlined,
                    size: 60,
                    color: Colors.grey.shade400,
                  ),

                  const SizedBox(height: 10),

                  const Text(
                    "No notifications yet.",
                    style: TextStyle(
                      color: Colors.grey,
                    ),
                  ),
                ],
              ),
            );
          }

          List alerts = snapshot.data!;

          return RefreshIndicator(
            onRefresh: _refresh,

            child: ListView.builder(
              padding: const EdgeInsets.all(15),

              itemCount: alerts.length,

              itemBuilder: (context, index) {

                var alert = alerts[index];

                bool isRead =
                    alert['is_read'].toString() == "1";

                Color alertColor =
                alert['alert_type'] == 'danger'
                    ? Colors.red
                    : alert['alert_type'] == 'warning'
                    ? Colors.orange
                    : Colors.blue;

                return InkWell(

                  onTap: () async {

                    if (!isRead) {

                      await _markAsRead(
                        alert['id'].toString(),
                      );

                      setState(() {
                        alert['is_read'] = 1;
                      });
                    }
                  },

                  borderRadius:
                  BorderRadius.circular(12),

                  child: Container(

                    margin:
                    const EdgeInsets.only(bottom: 12),

                    decoration: BoxDecoration(

                      color: isRead
                          ? Colors.white
                          : Colors.blue.shade50,

                      borderRadius:
                      BorderRadius.circular(12),

                      border: Border(
                        left: BorderSide(
                          color: alertColor,
                          width: 5,
                        ),
                      ),

                      boxShadow: [
                        BoxShadow(
                          color:
                          Colors.black.withOpacity(0.03),
                          blurRadius: 5,
                          offset: const Offset(0, 2),
                        ),
                      ],
                    ),

                    child: ListTile(

                      contentPadding:
                      const EdgeInsets.symmetric(
                        horizontal: 15,
                        vertical: 10,
                      ),

                      leading: Stack(
                        children: [

                          CircleAvatar(
                            radius: 24,

                            backgroundColor:
                            alertColor.withOpacity(0.1),

                            child: Icon(
                              alert['alert_type'] ==
                                  'danger'
                                  ? Icons.priority_high
                                  : Icons.info_outline,

                              color: alertColor,
                            ),
                          ),

                          if (!isRead)
                            Positioned(
                              top: 0,
                              right: 0,
                              child: Container(
                                width: 12,
                                height: 12,

                                decoration:
                                const BoxDecoration(
                                  color: Colors.red,
                                  shape: BoxShape.circle,
                                ),
                              ),
                            ),
                        ],
                      ),

                      title: Row(
                        children: [

                          Expanded(
                            child: Text(
                              alert['title'] ??
                                  "No Title",

                              style: TextStyle(
                                fontSize: 16,

                                fontWeight: isRead
                                    ? FontWeight.normal
                                    : FontWeight.bold,
                              ),
                            ),
                          ),

                          if (!isRead)
                            Container(
                              padding:
                              const EdgeInsets.symmetric(
                                horizontal: 8,
                                vertical: 3,
                              ),

                              decoration: BoxDecoration(
                                color: Colors.red,
                                borderRadius:
                                BorderRadius.circular(20),
                              ),

                              child: const Text(
                                "NEW",
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 10,
                                  fontWeight:
                                  FontWeight.bold,
                                ),
                              ),
                            ),
                        ],
                      ),

                      subtitle: Padding(
                        padding:
                        const EdgeInsets.only(top: 5),

                        child: Text(
                          alert['message'] ?? "",
                          style: const TextStyle(
                            fontSize: 13,
                          ),
                        ),
                      ),

                      trailing: Text(
                        alert['created_at']
                            .toString()
                            .split(' ')[0],

                        style: const TextStyle(
                          fontSize: 10,
                          color: Colors.grey,
                        ),
                      ),
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
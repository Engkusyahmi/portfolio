import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class HistoryScreen extends StatefulWidget {
  final String deviceId;
  final String userId;

  const HistoryScreen({
    super.key,
    required this.deviceId,
    required this.userId
  });

  @override
  State<HistoryScreen> createState() => _HistoryScreenState();
}

class _HistoryScreenState extends State<HistoryScreen> {
  // Variable untuk simpan Future supaya UI lebih stabil
  Future<List<dynamic>>? _historyFuture;

  @override
  void initState() {
    super.initState();
    _initFetch();
  }

  // Fungsi untuk mulakan pengambilan data
  void _initFetch() {
    _historyFuture = fetchHistory();
  }

  Future<List<dynamic>> fetchHistory() async {
    try {
      // Pastikan ID tidak kosong sebelum hantar ke API
      String dId = widget.deviceId.isEmpty ? "ESP-WASH-01" : widget.deviceId;
      String uId = widget.userId.isEmpty ? "1" : widget.userId;

      final url = Uri.parse(
          'https://078730.unisza.work/webapp/api/get_history.php?device_id=$dId&user_id=$uId');

      final response = await http.get(url).timeout(const Duration(seconds: 10));

      if (response.statusCode == 200) {
        // Decode JSON dan pastikan ia adalah List
        final dynamic decodedData = json.decode(response.body);
        if (decodedData is List) {
          return decodedData;
        }
      }
      return [];
    } catch (e) {
      debugPrint("Error fetching history: $e");
      return [];
    }
  }

  Color getCategoryColor(String category) {
    switch (category) {
      case "High Usage":
        return Colors.redAccent;
      case "Eco Usage":
        return Colors.green;
      default:
        return Colors.blueAccent; // Normal Usage
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
            "Usage History",
            style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18)
        ),
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF003366),
        elevation: 0,
        centerTitle: true,
      ),
      body: RefreshIndicator(
        onRefresh: () async {
          setState(() {
            _initFetch();
          });
        },
        child: FutureBuilder<List<dynamic>>(
          future: _historyFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            }

            if (snapshot.hasError || !snapshot.hasData || snapshot.data!.isEmpty) {
              return ListView(
                children: [
                  SizedBox(height: MediaQuery.of(context).size.height * 0.3),
                  const Center(
                    child: Column(
                      children: [
                        Icon(Icons.history_toggle_off, size: 60, color: Colors.grey),
                        SizedBox(height: 10),
                        Text("No records found", style: TextStyle(color: Colors.grey)),
                        Text("Pull down to refresh", style: TextStyle(fontSize: 12, color: Colors.blue)),
                      ],
                    ),
                  ),
                ],
              );
            }

            final history = snapshot.data!;

            return ListView.builder(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
              itemCount: history.length,
              itemBuilder: (context, index) {
                final log = history[index];

                // Parsing data dengan selamat
                String dateLabel = log['date']?.toString() ?? "Unknown Date";
                double totalLiters = double.tryParse(log['total']?.toString() ?? "0") ?? 0.0;
                String category = log['category']?.toString() ?? "Normal";

                return Container(
                  margin: const EdgeInsets.only(bottom: 12),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(16),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withOpacity(0.05),
                        blurRadius: 10,
                        offset: const Offset(0, 4),
                      ),
                    ],
                  ),
                  child: ListTile(
                    contentPadding: const EdgeInsets.all(16),
                    title: Text(
                      dateLabel,
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                    ),
                    subtitle: Padding(
                      padding: const EdgeInsets.only(top: 8.0),
                      child: Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                            decoration: BoxDecoration(
                              color: getCategoryColor(category).withOpacity(0.1),
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: Text(
                              category,
                              style: TextStyle(
                                color: getCategoryColor(category),
                                fontSize: 11,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    trailing: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.end,
                      children: [
                        Text(
                          "${totalLiters.toStringAsFixed(1)} L",
                          style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.bold,
                            color: Colors.blue.shade900,
                          ),
                        ),
                        const Text(
                            "Daily Total",
                            style: TextStyle(fontSize: 10, color: Colors.grey)
                        ),
                      ],
                    ),
                  ),
                );
              },
            );
          },
        ),
      ),
    );
  }
}
import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:aquamonitor/screens/water_budget_screen.dart';
import 'package:aquamonitor/screens/notification_screen.dart';

class DashboardScreen extends StatefulWidget {
  final String userId;
  final String deviceId;
  final String fullname;

  const DashboardScreen({
    super.key,
    required this.userId,
    required this.deviceId,
    required this.fullname,
  });

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  String? currentDeviceId;
  bool isInitialLoading = true;

  Future<Map<String, dynamic>>? _dashboardFuture;
  Future<List<FlSpot>>? _chartFuture;

  @override
  void initState() {
    super.initState();
    currentDeviceId = widget.deviceId;
    _initDataFetch();
  }

  // Fungsi utama untuk ambil semua data
  void _initDataFetch() {
    _dashboardFuture = fetchDashboardData();
    // Kita panggil fetchChartData terus guna widget.deviceId dulu sebagai backup
    _chartFuture = fetchChartData(currentDeviceId ?? widget.deviceId);
  }

  Future<Map<String, dynamic>> fetchDashboardData() async {
    try {
      final response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_user_stats.php?user_id=${widget.userId}'),
      ).timeout(const Duration(seconds: 10));

      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        String newDeviceId = data['device_id'] ?? widget.deviceId;

        if (mounted) {
          setState(() {
            currentDeviceId = newDeviceId;
            isInitialLoading = false;
            // CRITICAL: Update chart future bila deviceId baru masuk
            _chartFuture = fetchChartData(newDeviceId);
          });
        }
        return data;
      }
    } catch (e) {
      debugPrint("Error Fetch Stats: $e");
    }
    return {};
  }

  Future<List<FlSpot>> fetchChartData(String idToUse) async {
    if (idToUse.isEmpty || idToUse == "null" || idToUse == "No Device") {
      return [];
    }

    try {
      final response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_dashboard_chart.php?device_id=$idToUse'),
      ).timeout(const Duration(seconds: 10));

      if (response.statusCode == 200) {
        List<dynamic> data = json.decode(response.body);
        if (data.isEmpty) return [];

        List<FlSpot> spots = data.map((item) {
          return FlSpot(
              double.parse(item['x'].toString()),
              double.parse(item['y'].toString())
          );
        }).toList();

        spots.sort((a, b) => a.x.compareTo(b.x));
        return spots;
      }
    } catch (e) {
      debugPrint("Error Fetch Chart: $e");
    }
    return [];
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF0F5F9),
      appBar: _buildAppBar(),
      body: RefreshIndicator(
        onRefresh: () async {
          setState(() {
            _initDataFetch();
          });
        },
        child: FutureBuilder<Map<String, dynamic>>(
          future: _dashboardFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting && isInitialLoading) {
              return const Center(child: CircularProgressIndicator());
            }

            var data = snapshot.data ?? {};
            double totalUsage = double.tryParse(data['total_today']?.toString() ?? "0") ?? 0.0;
            double dailyLimit = double.tryParse(data['daily_limit']?.toString() ?? "0") ?? 0.0;

            return SingleChildScrollView(
              physics: const AlwaysScrollableScrollPhysics(),
              padding: const EdgeInsets.all(16.0),
              child: Column(
                children: [
                  _buildDeviceStatus(currentDeviceId ?? "Not Linked"),
                  const SizedBox(height: 16),
                  _buildBudgetProgress(totalUsage, dailyLimit),
                  const SizedBox(height: 16),
                  _buildMainConsumptionCard(totalUsage),
                  const SizedBox(height: 16),
                  _buildLiveChartSection(),
                ],
              ),
            );
          },
        ),
      ),
    );
  }

  AppBar _buildAppBar() {
    return AppBar(
      backgroundColor: Colors.white,
      elevation: 0,
      title: const Text("AquaMonitor",
          style: TextStyle(color: Color(0xFF003366), fontWeight: FontWeight.bold)),
      actions: [
        IconButton(
          icon: const Icon(Icons.notifications_active, color: Color(0xFF4A00E0)),
          onPressed: () => Navigator.push(context,
              MaterialPageRoute(builder: (context) => NotificationScreen(userId: widget.userId))),
        ),
        Center(child: Text(widget.fullname,
            style: const TextStyle(color: Colors.black87, fontSize: 12))),
        const SizedBox(width: 15),
      ],
    );
  }

  Widget _buildDeviceStatus(String id) {
    bool isOnline = id.isNotEmpty && id != "null" && id != "No Device";
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
      child: Row(
        children: [
          CircleAvatar(radius: 5, backgroundColor: isOnline ? Colors.green : Colors.grey),
          const SizedBox(width: 8),
          Text("Device: $id"),
          const Spacer(),
          Text(isOnline ? "Online" : "Offline",
              style: TextStyle(color: isOnline ? Colors.green : Colors.grey, fontWeight: FontWeight.bold)),
        ],
      ),
    );
  }

  Widget _buildBudgetProgress(double usage, double limit) {
    double percentage = (limit > 0) ? (usage / limit) : 0.0;
    if (percentage > 1.0) percentage = 1.0;
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(15)),
      child: Row(
        children: [
          Stack(
            alignment: Alignment.center,
            children: [
              SizedBox(width: 60, height: 60,
                  child: CircularProgressIndicator(value: percentage, strokeWidth: 6, color: Colors.blue)),
              Text("${(percentage * 100).toInt()}%",
                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold)),
            ],
          ),
          const SizedBox(width: 20),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text("Water Budget", style: TextStyle(fontWeight: FontWeight.bold)),
                Text("Used ${usage.toStringAsFixed(1)}L / ${limit.toInt()}L",
                    style: const TextStyle(color: Colors.grey, fontSize: 12)),
              ],
            ),
          ),
          TextButton(
            onPressed: () => Navigator.push(context,
                MaterialPageRoute(builder: (context) => WaterBudgetScreen(userId: widget.userId))),
            child: const Text("Set"),
          )
        ],
      ),
    );
  }

  Widget _buildMainConsumptionCard(double totalUsage) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        gradient: const LinearGradient(colors: [Color(0xFF0066FF), Color(0xFF00CCFF)]),
        borderRadius: BorderRadius.circular(20),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text("Today's Total", style: TextStyle(color: Colors.white70)),
          Text("${totalUsage.toStringAsFixed(1)} L",
              style: const TextStyle(color: Colors.white, fontSize: 36, fontWeight: FontWeight.bold)),
        ],
      ),
    );
  }

  Widget _buildLiveChartSection() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(15)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text("Hourly Usage Trend",
              style: TextStyle(fontWeight: FontWeight.bold, color: Colors.grey)),
          const SizedBox(height: 15),
          SizedBox(
            height: 150,
            child: FutureBuilder<List<FlSpot>>(
              future: _chartFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                }

                final spots = snapshot.data ?? [];
                if (spots.isEmpty) {
                  return const Center(child: Text("No Data", style: TextStyle(fontSize: 12)));
                }

                return LineChart(LineChartData(
                  minX: 0, maxX: 23, minY: 0,
                  gridData: const FlGridData(show: false),
                  borderData: FlBorderData(show: false),
                  titlesData: FlTitlesData(
                    topTitles: const AxisTitles(sideTitles: SideTitles(showTitles: false)),
                    rightTitles: const AxisTitles(sideTitles: SideTitles(showTitles: false)),
                    leftTitles: const AxisTitles(sideTitles: SideTitles(showTitles: false)),
                    bottomTitles: AxisTitles(
                      sideTitles: SideTitles(
                        showTitles: true,
                        interval: 6,
                        getTitlesWidget: (val, meta) => Text("${val.toInt()}h",
                            style: const TextStyle(fontSize: 10)),
                      ),
                    ),
                  ),
                  lineBarsData: [
                    LineChartBarData(
                      spots: spots,
                      isCurved: true,
                      color: Colors.blue,
                      barWidth: 3,
                      dotData: const FlDotData(show: true),
                      belowBarData: BarAreaData(show: true, color: Colors.blue.withOpacity(0.1)),
                    ),
                  ],
                ));
              },
            ),
          ),
        ],
      ),
    );
  }
}
import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:async';
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

  double todayTotalUsage = 0.0;
  double activeDailyLimit = 200.0;
  int unreadNotificationsCount = 0; // Tambah state ini

  List<FlSpot> _chartSpots = [];
  Timer? _liveRefreshTimer;
  bool isChartLoading = true;

  @override
  void initState() {
    super.initState();
    currentDeviceId = widget.deviceId;
    _fetchInitialDashboardData();

    _liveRefreshTimer = Timer.periodic(const Duration(seconds: 5), (timer) {
      _fetchPeriodicUpdates();
    });
  }

  @override
  void dispose() {
    _liveRefreshTimer?.cancel();
    super.dispose();
  }

  Future<void> _fetchInitialDashboardData() async {
    await Future.wait([
      fetchDashboardData(),
      _fetchUnreadNotificationCount(),
    ]);

    if (currentDeviceId != null && currentDeviceId != "No Device") {
      await fetchLiveChartData(currentDeviceId!);
    }
    if (mounted) {
      setState(() {
        isInitialLoading = false;
      });
    }
  }

  void _fetchPeriodicUpdates() {
    if (!mounted) return;
    fetchDashboardData();
    _fetchUnreadNotificationCount();
    if (currentDeviceId != null && currentDeviceId != "No Device" && currentDeviceId!.isNotEmpty) {
      fetchLiveChartData(currentDeviceId!);
    }
  }

  Future<void> _fetchUnreadNotificationCount() async {
    try {
      final response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_alerts.php?user_id=${widget.userId}'),
      ).timeout(const Duration(seconds: 5));

      if (response.statusCode == 200) {
        final List data = json.decode(response.body);
        int count = data.where((item) => item['is_read'].toString() == "0").length;
        if (mounted) setState(() => unreadNotificationsCount = count);
      }
    } catch (e) {
      debugPrint("Notification Count Error: $e");
    }
  }

  Future<void> fetchDashboardData() async {
    try {
      final response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_user_stats.php?user_id=${widget.userId}'),
      ).timeout(const Duration(seconds: 5));

      if (response.statusCode == 200) {
        final Map<String, dynamic> data = json.decode(response.body);
        if (mounted) {
          setState(() {
            currentDeviceId = data['device_id'] ?? widget.deviceId;
            todayTotalUsage = double.tryParse(data['total_today']?.toString() ?? "0") ?? 0.0;
            activeDailyLimit = double.tryParse(data['daily_limit']?.toString() ?? "0") ?? 0.0;
          });
        }
      }
    } catch (e) {
      debugPrint("Live Data Fetch Error: $e");
    }
  }

  Future<void> fetchLiveChartData(String idToUse) async {
    try {
      final response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/get_hourly_trend.php?device_id=$idToUse'),
      ).timeout(const Duration(seconds: 5));

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = json.decode(response.body);
        if (jsonResponse['status'] == 'success') {
          List<dynamic> dataList = jsonResponse['data'];
          List<FlSpot> tempSpots = List.generate(dataList.length, (i) {
            double yVal = double.tryParse(dataList[i]['value'].toString()) ?? 0.0;
            return FlSpot(i.toDouble(), yVal);
          });

          if (mounted) {
            setState(() {
              _chartSpots = tempSpots;
              isChartLoading = false;
            });
          }
        }
      }
    } catch (e) {
      debugPrint("Live Graph Fetch Error: $e");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF0F5F9),
      appBar: _buildAppBar(),
      body: isInitialLoading
          ? const Center(child: CircularProgressIndicator())
          : RefreshIndicator(
        onRefresh: () async => _fetchPeriodicUpdates(),
        child: SingleChildScrollView(
          physics: const AlwaysScrollableScrollPhysics(),
          padding: const EdgeInsets.all(16.0),
          child: Column(
            children: [
              _buildDeviceStatus(currentDeviceId ?? "Not Linked"),
              const SizedBox(height: 16),
              _buildBudgetProgress(todayTotalUsage, activeDailyLimit),
              const SizedBox(height: 16),
              _buildMainConsumptionCard(todayTotalUsage),
              const SizedBox(height: 16),
              _buildLiveChartSection(),
            ],
          ),
        ),
      ),
    );
  }

  AppBar _buildAppBar() {
    return AppBar(
      backgroundColor: Colors.white,
      elevation: 0.5,
      title: const Text("AquaMonitor", style: TextStyle(color: Color(0xFF003366), fontWeight: FontWeight.bold)),
      actions: [
        Stack(
          alignment: Alignment.center,
          children: [
            IconButton(
              icon: const Icon(Icons.notifications_active, color: Color(0xFF4A00E0)),
              onPressed: () async {
                await Navigator.push(context, MaterialPageRoute(builder: (context) => NotificationScreen(userId: widget.userId)));
                _fetchUnreadNotificationCount(); // Refresh lepas balik dari skrin notifikasi
              },
            ),
            if (unreadNotificationsCount > 0)
              Positioned(
                right: 8,
                top: 8,
                child: Container(
                  padding: const EdgeInsets.all(4),
                  decoration: const BoxDecoration(color: Colors.red, shape: BoxShape.circle),
                  constraints: const BoxConstraints(minWidth: 16, minHeight: 16),
                  child: Text("$unreadNotificationsCount", style: const TextStyle(color: Colors.white, fontSize: 9, fontWeight: FontWeight.bold), textAlign: TextAlign.center),
                ),
              ),
          ],
        ),
        Center(child: Text(widget.fullname, style: const TextStyle(color: Colors.black87, fontSize: 12))),
        const SizedBox(width: 15),
      ],
    );
  }

  Widget _buildDeviceStatus(String id) {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.grey.shade100)),
      child: Row(
        children: [
          const Icon(Icons.developer_board, color: Color(0xFF003366), size: 20),
          const SizedBox(width: 10),
          Text("Device ID: $id", style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color(0xFF003366))),
        ],
      ),
    );
  }

  Widget _buildBudgetProgress(double usage, double limit) {
    double percentage = (limit > 0) ? (usage / limit).clamp(0.0, 1.0) : 0.0;
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(15)),
      child: Row(
        children: [
          Stack(
            alignment: Alignment.center,
            children: [
              SizedBox(width: 60, height: 60, child: CircularProgressIndicator(value: percentage, strokeWidth: 6, color: Colors.blue)),
              Text("${(percentage * 100).toInt()}%", style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold)),
            ],
          ),
          const SizedBox(width: 20),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text("Water Budget", style: TextStyle(fontWeight: FontWeight.bold)),
                Text("Used ${usage.toStringAsFixed(1)}L / ${limit.toInt()}L", style: const TextStyle(color: Colors.grey, fontSize: 12)),
              ],
            ),
          ),
          TextButton(onPressed: () => Navigator.push(context, MaterialPageRoute(builder: (context) => WaterBudgetScreen(userId: widget.userId))), child: const Text("Set")),
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
          Text("${totalUsage.toStringAsFixed(1)} L", style: const TextStyle(color: Colors.white, fontSize: 36, fontWeight: FontWeight.bold)),
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
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text("Real-Time Usage", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.grey)),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                decoration: BoxDecoration(color: Colors.red.shade50, borderRadius: BorderRadius.circular(6)),
                child: Row(
                  children: [
                    CircleAvatar(radius: 3, backgroundColor: Colors.red.shade700),
                    const SizedBox(width: 4),
                    Text("LIVE", style: TextStyle(fontSize: 10, color: Colors.red.shade700, fontWeight: FontWeight.bold)),
                  ],
                ),
              )
            ],
          ),
          const SizedBox(height: 15),
          SizedBox(
            height: 150,
            child: isChartLoading
                ? const Center(child: CircularProgressIndicator())
                : _chartSpots.isEmpty
                ? const Center(child: Text("Waiting for ESP32 data...", style: TextStyle(fontSize: 12)))
                : LineChart(LineChartData(
              minY: 0,
              gridData: const FlGridData(show: true, drawVerticalLine: false),
              borderData: FlBorderData(show: false),
              titlesData: const FlTitlesData(
                topTitles: AxisTitles(sideTitles: SideTitles(showTitles: false)),
                rightTitles: AxisTitles(sideTitles: SideTitles(showTitles: false)),
                leftTitles: AxisTitles(sideTitles: SideTitles(showTitles: true, reservedSize: 30)),
                bottomTitles: AxisTitles(sideTitles: SideTitles(showTitles: false)),
              ),
              lineBarsData: [
                LineChartBarData(
                  spots: _chartSpots,
                  isCurved: true,
                  color: Colors.blue.shade700,
                  barWidth: 3,
                  dotData: const FlDotData(show: true),
                  belowBarData: BarAreaData(show: true, color: Colors.blue.withOpacity(0.1)),
                ),
              ],
            )),
          ),
        ],
      ),
    );
  }
}
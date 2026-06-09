import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class StatisticsScreen extends StatefulWidget {
  final String deviceId;

  const StatisticsScreen({super.key, required this.deviceId});

  @override
  State<StatisticsScreen> createState() => _StatisticsScreenState();
}

class _StatisticsScreenState extends State<StatisticsScreen> {

  Future<List<dynamic>> fetchWeeklyData() async {
    try {
      // Jika deviceId kosong, fallback ke ID default untuk testing
      String id = (widget.deviceId.isEmpty || widget.deviceId == "null") ? "ESP-WASH-01" : widget.deviceId;

      final url = 'https://078730.unisza.work/webapp/api/get_weekly_stats.php?device_id=$id';
      final response = await http.get(Uri.parse(url));

      if (response.statusCode == 200) {
        // Handle unexpected string errors from PHP
        if (response.body.startsWith('[')) {
          return json.decode(response.body);
        } else {
          debugPrint("Server Error Response: ${response.body}");
          return [];
        }
      }
    } catch (e) {
      debugPrint("Connection Error: $e");
    }
    return [];
  }

  double _calculateMaxY(List<dynamic> data) {
    if (data.isEmpty) return 100;
    double max = 0;
    for (var item in data) {
      double val = double.tryParse(item['total'].toString()) ?? 0;
      if (val > max) max = val;
    }
    return max > 0 ? max + (max * 0.2) : 100;
  }

  String _calculateAverage(List<dynamic> data) {
    if (data.isEmpty) return "0.0";
    double total = data.fold(0, (sum, item) => sum + (double.tryParse(item['total'].toString()) ?? 0));
    return (total / data.length).toStringAsFixed(1);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text("Usage Statistics", style: TextStyle(color: Color(0xFF003366), fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white,
        elevation: 0,
        centerTitle: true,
      ),
      body: FutureBuilder<List<dynamic>>(
        future: fetchWeeklyData(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          List<dynamic> data = snapshot.data ?? [];

          if (data.isEmpty) {
            return RefreshIndicator(
              onRefresh: () async => setState(() {}),
              child: ListView(
                children: const [
                  SizedBox(height: 100),
                  Center(child: Text("Tiada data ditemui untuk 7 hari terakhir.")),
                  Center(child: Text("Sila tarik skrin ke bawah untuk refresh.", style: TextStyle(fontSize: 12, color: Colors.grey))),
                ],
              ),
            );
          }

          return RefreshIndicator(
            onRefresh: () async => setState(() {}),
            child: SingleChildScrollView(
              physics: const AlwaysScrollableScrollPhysics(),
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text("Weekly Overview", style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Color(0xFF003366))),
                  const SizedBox(height: 20),
                  _buildChartContainer(data),
                  const SizedBox(height: 30),
                  _buildInsightTile("Average Daily Usage", "${_calculateAverage(data)} L", Icons.analytics_outlined, Colors.orange),
                  const SizedBox(height: 10),
                  _buildInsightTile("Total This Week", "${data.fold(0.0, (sum, item) => sum + (double.tryParse(item['total'].toString()) ?? 0)).toStringAsFixed(1)} L", Icons.water_drop, Colors.blue),
                ],
              ),
            ),
          );
        },
      ),
    );
  }

  Widget _buildChartContainer(List<dynamic> data) {
    return Container(
      height: 350,
      padding: const EdgeInsets.only(top: 20, right: 20, left: 10, bottom: 10),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(20)),
      child: BarChart(
        BarChartData(
          alignment: BarChartAlignment.spaceAround,
          maxY: _calculateMaxY(data),
          titlesData: FlTitlesData(
            bottomTitles: AxisTitles(
              sideTitles: SideTitles(
                showTitles: true,
                getTitlesWidget: (value, meta) {
                  int index = value.toInt();
                  if (index >= 0 && index < data.length) {
                    return Text(data[index]['day'], style: const TextStyle(fontSize: 12));
                  }
                  return const Text('');
                },
              ),
            ),
            leftTitles: const AxisTitles(sideTitles: SideTitles(showTitles: false)),
            topTitles: const AxisTitles(sideTitles: SideTitles(showTitles: false)),
            rightTitles: const AxisTitles(sideTitles: SideTitles(showTitles: false)),
          ),
          borderData: FlBorderData(show: false),
          barGroups: data.asMap().entries.map((entry) {
            return BarChartGroupData(
              x: entry.key,
              barRods: [BarChartRodData(toY: double.tryParse(entry.value['total'].toString()) ?? 0, color: Colors.blue.shade700, width: 20)],
            );
          }).toList(),
        ),
      ),
    );
  }

  Widget _buildInsightTile(String title, String value, IconData icon, Color color) {
    return Container(
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(15)),
      child: ListTile(
        leading: CircleAvatar(backgroundColor: color.withOpacity(0.1), child: Icon(icon, color: color)),
        title: Text(title, style: const TextStyle(fontSize: 14, color: Colors.grey)),
        trailing: Text(value, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
      ),
    );
  }
}
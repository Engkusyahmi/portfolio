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
  String _selectedView = 'weekly';

  // --- KEMASKINI UTAMA: Fungsi pembantunya dipaksa secara mutlak guna parsing matematik ---
  String _formatUsage(dynamic value) {
    if (value == null) return "0";

    // Guna double parsing yang selamat
    double numValue = double.tryParse(value.toString()) ?? 0.0;
    if (numValue == 0) return "0";

    // Langkah 1: Paksa tukar kepada string 2 tempat perpuluhan terlebih dahulu (Buang terus baki hanyut)
    String fixedStr = numValue.toStringAsFixed(2);
    double cleanValue = double.parse(fixedStr);

    // Langkah 2: Jika selepas dipotong dua angka belakang nilainya tiada baki (contoh: 120.00), pulangkan nombor bulat
    if (cleanValue % 1 == 0) {
      return cleanValue.toStringAsFixed(0); // Tunjuk "120" bukan "120.00" atau "120.0"
    }

    return fixedStr; // Pulangkan format tepat "245.39"
  }

  Future<List<dynamic>> fetchStatisticsData() async {
    try {
      String id = widget.deviceId.trim();

      if (id.isEmpty || id == "null" || id == "No Device") {
        debugPrint("Statistics: No valid deviceId found for this account.");
        return [];
      }

      String endpoint = _selectedView == 'weekly' ? 'get_weekly_stats.php' : 'get_monthly_stats.php';
      final url = 'https://078730.unisza.work/webapp/api/$endpoint?device_id=$id';

      final response = await http.get(Uri.parse(url));

      if (response.statusCode == 200) {
        if (response.body.startsWith('[')) {
          return json.decode(response.body);
        } else {
          debugPrint("Server Response Error: ${response.body}");
          return [];
        }
      } else {
        debugPrint("HTTP Server Error: ${response.statusCode}");
      }
    } catch (e) {
      debugPrint("Statistics Connection Error: $e");
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
    if (data.isEmpty) return "0";
    double total = data.fold(0, (sum, item) => sum + (double.tryParse(item['total'].toString()) ?? 0));
    return _formatUsage(total / data.length);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
            "Usage Statistics",
            style: TextStyle(color: Color(0xFF003366), fontWeight: FontWeight.bold)
        ),
        backgroundColor: Colors.white,
        elevation: 0.5,
        centerTitle: true,
      ),
      body: Column(
        children: [
          const SizedBox(height: 15),
          Center(
            child: SegmentedButton<String>(
              segments: const <ButtonSegment<String>>[
                ButtonSegment<String>(
                  value: 'weekly',
                  label: Text('Weekly'),
                  icon: Icon(Icons.view_week_outlined, size: 18),
                ),
                ButtonSegment<String>(
                  value: 'monthly',
                  label: Text('Monthly'),
                  icon: Icon(Icons.calendar_month_outlined, size: 18),
                ),
              ],
              selected: <String>{_selectedView},
              onSelectionChanged: (Set<String> newSelection) {
                setState(() {
                  _selectedView = newSelection.first;
                });
              },
              style: SegmentedButton.styleFrom(
                selectedBackgroundColor: const Color(0xFF003366),
                selectedForegroundColor: Colors.white,
                foregroundColor: Colors.grey.shade700,
                backgroundColor: Colors.white,
                side: BorderSide(color: Colors.grey.shade300),
              ),
            ),
          ),
          const SizedBox(height: 15),

          Expanded(
            child: FutureBuilder<List<dynamic>>(
              future: fetchStatisticsData(),
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
                        SizedBox(height: 120),
                        Center(child: Icon(Icons.bar_chart_outlined, size: 60, color: Colors.grey)),
                        SizedBox(height: 10),
                        Center(
                            child: Text(
                                "No statistical data found for this selection.",
                                style: TextStyle(fontWeight: FontWeight.bold, color: Colors.blueGrey)
                            )
                        ),
                        Center(
                            child: Text(
                                "Please pull down the screen to refresh data.",
                                style: TextStyle(fontSize: 12, color: Colors.grey)
                            )
                        ),
                      ],
                    ),
                  );
                }

                double totalUsage = data.fold(0.0, (sum, item) => sum + (double.tryParse(item['total'].toString()) ?? 0));

                return RefreshIndicator(
                  onRefresh: () async => setState(() {}),
                  child: SingleChildScrollView(
                    physics: const AlwaysScrollableScrollPhysics(),
                    padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                            _selectedView == 'weekly' ? "Weekly Overview" : "Monthly Overview",
                            style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Color(0xFF003366))
                        ),
                        const SizedBox(height: 15),
                        _buildChartContainer(data),
                        const SizedBox(height: 25),
                        _buildInsightTile(
                            _selectedView == 'weekly' ? "Average Daily Usage" : "Average Monthly Usage",
                            "${_calculateAverage(data)} L",
                            Icons.analytics_outlined,
                            Colors.orange
                        ),
                        const SizedBox(height: 12),
                        _buildInsightTile(
                            _selectedView == 'weekly' ? "Total This Week" : "Total This Year",
                            "${_formatUsage(totalUsage)} L",
                            Icons.water_drop,
                            Colors.blue
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildChartContainer(List<dynamic> data) {
    return Container(
      height: 330,
      padding: const EdgeInsets.only(top: 25, right: 20, left: 10, bottom: 10),
      decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(20),
          boxShadow: [
            BoxShadow(
              color: Colors.grey.withOpacity(0.05),
              spreadRadius: 2,
              blurRadius: 10,
            )
          ]
      ),
      child: BarChart(
        BarChartData(
          alignment: BarChartAlignment.spaceAround,
          maxY: _calculateMaxY(data),
          barTouchData: BarTouchData(
            enabled: true, // Memastikan touch state dihidupkan sepenuhnya
            touchTooltipData: BarTouchTooltipData(
              tooltipBgColor: const Color(0xFF003366).withOpacity(0.9),
              tooltipPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
              tooltipMargin: 8,
              getTooltipItem: (group, groupIndex, rod, rodIndex) {
                // Di sini nilai dipotong dengan selamat melalui pembetulan fungsi _formatUsage yang baharu
                return BarTooltipItem(
                  "${_formatUsage(rod.toY)} L",
                  const TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                    fontSize: 13,
                  ),
                );
              },
            ),
          ),
          titlesData: FlTitlesData(
            bottomTitles: AxisTitles(
              sideTitles: SideTitles(
                showTitles: true,
                getTitlesWidget: (value, meta) {
                  int index = value.toInt();
                  if (index >= 0 && index < data.length) {
                    String label = data[index]['day'] ?? data[index]['month'] ?? '';
                    return Padding(
                      padding: const EdgeInsets.only(top: 8.0),
                      child: Text(
                          label,
                          style: const TextStyle(fontSize: 11, color: Colors.grey, fontWeight: FontWeight.bold)
                      ),
                    );
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
          gridData: const FlGridData(show: false),
          barGroups: data.asMap().entries.map((entry) {
            double barValue = double.tryParse(entry.value['total'].toString()) ?? 0;
            return BarChartGroupData(
              x: entry.key,
              barRods: [
                BarChartRodData(
                  toY: barValue,
                  color: const Color(0xFF003366),
                  width: _selectedView == 'weekly' ? 18 : 12,
                  borderRadius: const BorderRadius.only(
                    topLeft: Radius.circular(4),
                    topRight: Radius.circular(4),
                  ),
                )
              ],
            );
          }).toList(),
        ),
      ),
    );
  }

  Widget _buildInsightTile(String title, String value, IconData icon, Color color) {
    return Container(
      decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(15),
          border: Border.all(color: Colors.grey.shade100)
      ),
      child: ListTile(
        leading: CircleAvatar(
            backgroundColor: color.withOpacity(0.1),
            child: Icon(icon, color: color)
        ),
        title: Text(title, style: const TextStyle(fontSize: 13, color: Colors.grey, fontWeight: FontWeight.w500)),
        trailing: Text(value, style: const TextStyle(fontSize: 17, fontWeight: FontWeight.bold, color: Color(0xFF003366))),
      ),
    );
  }
}
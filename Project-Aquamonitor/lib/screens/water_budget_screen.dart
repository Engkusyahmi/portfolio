import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class WaterBudgetScreen extends StatefulWidget {
  final String userId;

  const WaterBudgetScreen({super.key, required this.userId});

  @override
  State<WaterBudgetScreen> createState() => _WaterBudgetScreenState();
}

class _WaterBudgetScreenState extends State<WaterBudgetScreen> {
  final _limitController = TextEditingController();
  final _residentController = TextEditingController();
  bool _isLoading = false;

  @override
  void initState() {
    super.initState();
    _loadBudgetData(); // Bila buka screen, terus tarik data lama (Read)
  }

  // 1. Fungsi READ (Ambil data dari database)
  Future<void> _loadBudgetData() async {
    setState(() => _isLoading = true);
    try {
      var response = await http.get(
        Uri.parse('https://078730.unisza.work/webapp/api/manage_budget.php?user_id=${widget.userId}'),
      );

      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        if (data != null) {
          _limitController.text = data['daily_limit'].toString();
          _residentController.text = data['num_residents'].toString();
        }
      }
    } catch (e) {
      print("Error loading budget: $e");
    } finally {
      setState(() => _isLoading = false);
    }
  }

  // 2. Fungsi CREATE / UPDATE (Simpan data ke database)
  Future<void> _saveBudget() async {
    if (_limitController.text.isEmpty || _residentController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Please fill all fields")),
      );
      return;
    }

    setState(() => _isLoading = true);
    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/manage_budget.php'),
        body: {
          "user_id": widget.userId,
          "daily_limit": _limitController.text,
          "num_residents": _residentController.text,
        },
      );

      var data = json.decode(response.body);
      if (data['status'] == 'success') {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(backgroundColor: Colors.green, content: Text("Budget saved successfully!")),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(backgroundColor: Colors.red, content: Text("Error: $e")),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Household & Budget")),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              "Set Your Water Goal",
              style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
            ),
            const Text("Manage your daily consumption limit and household info."),
            const SizedBox(height: 30),

            TextField(
              controller: _limitController,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: "Daily Limit (Liters)",
                prefixIcon: Icon(Icons.water_drop),
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 20),

            TextField(
              controller: _residentController,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: "Number of Residents",
                prefixIcon: Icon(Icons.people),
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 30),

            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: _saveBudget,
                style: ElevatedButton.styleFrom(backgroundColor: Colors.blue, foregroundColor: Colors.white),
                child: const Text("Save Budget Settings"),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
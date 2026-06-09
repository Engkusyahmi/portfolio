import 'package:flutter/material.dart';
import 'package:aquamonitor/screens/dashboard_screen.dart';
import 'package:aquamonitor/screens/statistics_screen.dart';
import 'package:aquamonitor/screens/chatbot_screen.dart';
import 'package:aquamonitor/screens/profile_screen.dart';
import 'package:aquamonitor/screens/history_screen.dart';

class MainWrapper extends StatefulWidget {
  final String userId;
  final String deviceId;
  final String fullname;

  const MainWrapper({
    super.key,
    required this.userId,
    required this.deviceId,
    required this.fullname,
  });

  @override
  State<MainWrapper> createState() => _MainWrapperState();
}

class _MainWrapperState extends State<MainWrapper> {
  int _selectedIndex = 0;

  // Function untuk panggil skrin berdasarkan index yang dipilih
  Widget _getSelectedScreen() {
    switch (_selectedIndex) {
      case 0:
        return DashboardScreen(
          userId: widget.userId,
          deviceId: widget.deviceId,
          fullname: widget.fullname,
        );
      case 1:
      // SEKARANG KITA HANTAR deviceId KE SINI
        return StatisticsScreen(deviceId: widget.deviceId);
      case 2:
        return ChatbotScreen(userId: widget.userId);
      case 3:
        return HistoryScreen(
          deviceId: widget.deviceId,
          userId: widget.userId, // AMBIL DARI widget.userId, JANGAN LETAK ''
        );
      case 4:
        return ProfileScreen(
          userId: widget.userId,
          fullname: widget.fullname,
        );
      default:
        return Container();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // Paparkan skrin yang dipilih
      body: _getSelectedScreen(),

      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: (index) {
          setState(() {
            _selectedIndex = index;
          });
        },
        type: BottomNavigationBarType.fixed,
        selectedItemColor: Colors.blue.shade700,
        unselectedItemColor: Colors.grey,
        showUnselectedLabels: true,
        items: const [
          BottomNavigationBarItem(
              icon: Icon(Icons.dashboard_outlined),
              activeIcon: Icon(Icons.dashboard),
              label: "Home"
          ),
          BottomNavigationBarItem(
              icon: Icon(Icons.bar_chart_outlined),
              activeIcon: Icon(Icons.bar_chart),
              label: "Stats"
          ),
          BottomNavigationBarItem(
              icon: Icon(Icons.chat_bubble_outline),
              activeIcon: Icon(Icons.chat_bubble),
              label: "AI Chat"
          ),
          BottomNavigationBarItem(
              icon: Icon(Icons.history_outlined),
              activeIcon: Icon(Icons.history),
              label: "History"
          ),
          BottomNavigationBarItem(
              icon: Icon(Icons.person_outline),
              activeIcon: Icon(Icons.person),
              label: "Profile"
          ),
        ],
      ),
    );
  }
}
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:aquamonitor/screens/notification_screen.dart';
import 'package:aquamonitor/screens/statistics_screen.dart';
import 'package:aquamonitor/screens/water_budget_screen.dart';

class ChatbotScreen extends StatefulWidget {
  final String userId;
  final String deviceId;

  const ChatbotScreen({
    super.key,
    required this.userId,
    required this.deviceId,
  });

  @override
  State<ChatbotScreen> createState() => _ChatbotScreenState();
}

class _ChatbotScreenState extends State<ChatbotScreen> {
  final TextEditingController _controller = TextEditingController();
  final ScrollController _scrollController = ScrollController();

  final List<Map<String, dynamic>> _messages = [
    {
      "role": "bot",
      "text": "Hello! I am your AquaMonitor AI. How can I assist you today? 😊",
      "action": null
    }
  ];

  bool _isLoading = false;

  void _scrollToBottom() {
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (_scrollController.hasClients) {
        _scrollController.animateTo(
          _scrollController.position.maxScrollExtent,
          duration: const Duration(milliseconds: 300),
          curve: Curves.easeOut,
        );
      }
    });
  }

  Future<void> _sendMessage(String text) async {
    if (text.trim().isEmpty || _isLoading) return;

    final originalText = text.trim();

    setState(() {
      _messages.add({"role": "user", "text": originalText, "action": null});
      _isLoading = true;
    });

    _controller.clear();
    _scrollToBottom();

    try {
      var response = await http.post(
        Uri.parse('https://078730.unisza.work/webapp/api/chatbot_logic.php'),
        body: {
          "user_id": widget.userId,
          "message": originalText, // Hantar teks tanpa paksaan kerdil huruf di sini
        },
      ).timeout(const Duration(seconds: 15));

      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        if (mounted) {
          setState(() {
            _messages.add({
              "role": "bot",
              "text": data['reply'] ?? "I'm sorry, I couldn't process that request.",
              "action": data['action']
            });
          });
        }
      } else {
        if (mounted) {
          setState(() {
            _messages.add({"role": "bot", "text": "Server error: ${response.statusCode}", "action": null});
          });
        }
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _messages.add({"role": "bot", "text": "Error: Unable to connect to server.", "action": null});
        });
      }
    } finally {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
      _scrollToBottom();
    }
  }

  void _handleBotAction(String actionType) {
    if (actionType == "navigate_to_stats") {
      Navigator.push(
          context,
          MaterialPageRoute(
              builder: (context) => StatisticsScreen(deviceId: widget.deviceId)
          )
      );
    } else if (actionType == "navigate_to_budget") {
      Navigator.push(
          context,
          MaterialPageRoute(
              builder: (context) => WaterBudgetScreen(userId: widget.userId)
          )
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FBFF),
      body: Column(
        children: [
          _buildHeader(context),
          _buildQuickActions(),
          Expanded(child: _buildChatList()),
          _buildInputArea(),
        ],
      ),
    );
  }

  Widget _buildHeader(BuildContext context) {
    return Container(
      padding: const EdgeInsets.only(top: 50, bottom: 20, left: 20, right: 20),
      decoration: const BoxDecoration(
        gradient: LinearGradient(
          colors: [Color(0xFF8E2DE2), Color(0xFF4A00E0)],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(30),
          bottomRight: Radius.circular(30),
        ),
      ),
      child: Row(
        children: [
          const CircleAvatar(
            backgroundColor: Colors.white24,
            child: Icon(Icons.smart_toy_outlined, color: Colors.white),
          ),
          const SizedBox(width: 12),
          const Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text("AI Water Assistant", style: TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
                Text("Online | Smart Analysis Mode", style: TextStyle(color: Colors.white70, fontSize: 12)),
              ],
            ),
          ),
          IconButton(
            icon: const Icon(Icons.notifications_active, color: Colors.white),
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => NotificationScreen(userId: widget.userId)),
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildQuickActions() {
    final List<Map<String, String>> actions = [
      {"label": "Usage Status 📊", "msg": "check my usage status"},
      {"label": "Estimated Cost 💰", "msg": "how much is my water cost?"},
      {"label": "Admin's Saving Tips 💡", "msg": "give me a water saving tip"},
    ];

    return Container(
      height: 60,
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 15),
        itemCount: actions.length,
        itemBuilder: (context, index) {
          return Padding(
            padding: const EdgeInsets.only(right: 10),
            child: ActionChip(
              backgroundColor: Colors.white,
              elevation: 1,
              label: Text(actions[index]['label']!),
              labelStyle: const TextStyle(color: Color(0xFF4A00E0), fontSize: 12, fontWeight: FontWeight.bold),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(20),
                side: BorderSide(color: Colors.purple.shade100),
              ),
              onPressed: _isLoading ? null : () => _sendMessage(actions[index]['msg']!),
            ),
          );
        },
      ),
    );
  }

  Widget _buildChatList() {
    int itemCount = _messages.length + (_isLoading ? 1 : 0);

    return ListView.builder(
      controller: _scrollController,
      padding: const EdgeInsets.all(20),
      itemCount: itemCount,
      itemBuilder: (context, index) {
        if (index == _messages.length) {
          return _buildTypingIndicator();
        }

        bool isUser = _messages[index]["role"] == "user";
        String? botAction = _messages[index]["action"];

        return Align(
          alignment: isUser ? Alignment.centerRight : Alignment.centerLeft,
          child: Column(
            crossAxisAlignment: isUser ? CrossAxisAlignment.end : CrossAxisAlignment.start,
            children: [
              Container(
                margin: const EdgeInsets.symmetric(vertical: 4),
                padding: const EdgeInsets.all(14),
                constraints: BoxConstraints(maxWidth: MediaQuery.of(context).size.width * 0.75),
                decoration: BoxDecoration(
                  color: isUser ? const Color(0xFF4A00E0) : Colors.white,
                  borderRadius: BorderRadius.only(
                    topLeft: const Radius.circular(15),
                    topRight: const Radius.circular(15),
                    bottomLeft: Radius.circular(isUser ? 15 : 0),
                    bottomRight: Radius.circular(isUser ? 0 : 15),
                  ),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 5)],
                ),
                child: Text(
                  _messages[index]["text"]!,
                  style: TextStyle(color: isUser ? Colors.white : Colors.black87),
                ),
              ),
              if (!isUser && botAction != null)
                Padding(
                  padding: const EdgeInsets.only(left: 4, bottom: 8),
                  child: ElevatedButton.icon(
                    onPressed: () => _handleBotAction(botAction),
                    icon: const Icon(Icons.open_in_new, size: 14),
                    label: Text(
                      botAction == "navigate_to_stats" ? "View Full Report" : "Adjust Water Budget",
                      style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold),
                    ),
                    style: ElevatedButton.styleFrom(
                      foregroundColor: Colors.white,
                      backgroundColor: const Color(0xFF8E2DE2),
                      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                    ),
                  ),
                ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildTypingIndicator() {
    return Align(
      alignment: Alignment.centerLeft,
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 8),
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
        decoration: BoxDecoration(
          color: Colors.grey.shade200,
          borderRadius: const BorderRadius.only(
            topLeft: Radius.circular(15),
            topRight: Radius.circular(15),
            bottomRight: Radius.circular(15),
          ),
        ),
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text("AquaMonitor AI is thinking", style: TextStyle(fontSize: 12, color: Colors.grey.shade600, fontStyle: FontStyle.italic)),
            const SizedBox(width: 6),
            const SizedBox(
              width: 10,
              height: 10,
              child: CircularProgressIndicator(strokeWidth: 1.5, color: Color(0xFF4A00E0)),
            )
          ],
        ),
      ),
    );
  }

  Widget _buildInputArea() {
    return Container(
      padding: const EdgeInsets.all(15),
      decoration: const BoxDecoration(color: Colors.white, boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 10)]),
      child: Row(
        children: [
          Expanded(
            child: TextField(
              controller: _controller,
              enabled: !_isLoading,
              decoration: InputDecoration(
                hintText: _isLoading ? "AI is processing..." : "Type your question here...",
                border: OutlineInputBorder(borderRadius: BorderRadius.circular(25), borderSide: BorderSide.none),
                filled: true,
                fillColor: _isLoading ? Colors.grey.shade200 : Colors.grey.shade100,
                contentPadding: const EdgeInsets.symmetric(horizontal: 20),
              ),
              onSubmitted: (value) => _sendMessage(value),
            ),
          ),
          const SizedBox(width: 10),
          CircleAvatar(
            backgroundColor: _isLoading ? Colors.grey : const Color(0xFF4A00E0),
            child: IconButton(
              icon: const Icon(Icons.send, color: Colors.white),
              onPressed: _isLoading ? null : () => _sendMessage(_controller.text),
            ),
          ),
        ],
      ),
    );
  }
}
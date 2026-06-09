import 'package:flutter/material.dart';
import 'package:camera/camera.dart';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:screenshot/screenshot.dart';
import 'package:path_provider/path_provider.dart';
import 'package:image_picker/image_picker.dart';

late List<CameraDescription> _cameras;

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  try {
    _cameras = await availableCameras();
  } catch (e) {
    debugPrint("Kamera tidak dijumpai: $e");
  }
  runApp(const SakuLegacyApp());
}

class SakuLegacyApp extends StatelessWidget {
  const SakuLegacyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Saku Legacy',
      theme: ThemeData.dark().copyWith(
        scaffoldBackgroundColor: const Color(0xFF121212),
        primaryColor: Colors.blueAccent,
      ),
      home: const HomeScreen(),
    );
  }
}

// --- SCREEN 0: HOME SCREEN ---
class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  Future<void> _pickFromGallery(BuildContext context) async {
    final ImagePicker picker = ImagePicker();
    final XFile? image = await picker.pickImage(source: ImageSource.gallery);

    if (image != null && context.mounted) {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => FrameSelectionScreen(imagePath: image.path),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: double.infinity,
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [Color(0xFF1e3c72), Color(0xFF000000)],
          ),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.camera_rounded, size: 100, color: Colors.amber),
            const SizedBox(height: 20),
            const Text(
              "SAKU LEGACY",
              style: TextStyle(fontSize: 35, fontWeight: FontWeight.bold, letterSpacing: 3),
            ),
            const Text("Premium Fridge Magnet Printing", style: TextStyle(color: Colors.white70)),
            const SizedBox(height: 80),
            _buildMenuButton(
              context,
              icon: Icons.camera_alt_outlined,
              label: "TAKE A PHOTO",
              onTap: () => Navigator.push(context, MaterialPageRoute(builder: (context) => const CameraScreen())),
            ),
            const SizedBox(height: 20),
            _buildMenuButton(
              context,
              icon: Icons.image_search_outlined,
              label: "FROM GALLERY",
              onTap: () => _pickFromGallery(context),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildMenuButton(BuildContext context, {required IconData icon, required String label, required VoidCallback onTap}) {
    return SizedBox(
      width: 280,
      height: 65,
      child: ElevatedButton.icon(
        style: ElevatedButton.styleFrom(
          backgroundColor: Colors.white,
          foregroundColor: Colors.black,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(35)),
          elevation: 10,
        ),
        onPressed: onTap,
        icon: Icon(icon, size: 28),
        label: Text(label, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
      ),
    );
  }
}

// --- SCREEN 1: CAMERA SCREEN ---
class CameraScreen extends StatefulWidget {
  const CameraScreen({super.key});

  @override
  State<CameraScreen> createState() => _CameraScreenState();
}

class _CameraScreenState extends State<CameraScreen> {
  late CameraController controller;
  bool isTakingPicture = false;
  bool isInitialized = false;

  @override
  void initState() {
    super.initState();
    _initCamera();
  }

  Future<void> _initCamera() async {
    controller = CameraController(_cameras[0], ResolutionPreset.high, enableAudio: false);
    try {
      await controller.initialize();
      if (mounted) setState(() => isInitialized = true);
    } catch (e) {
      debugPrint("Gagal init kamera: $e");
    }
  }

  @override
  void dispose() {
    controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    if (!isInitialized) return const Scaffold(body: Center(child: CircularProgressIndicator()));

    return Scaffold(
      body: Stack(
        children: [
          Positioned.fill(child: CameraPreview(controller)),
          Positioned(
            top: 50,
            left: 20,
            child: CircleAvatar(
              backgroundColor: Colors.black54,
              child: IconButton(
                icon: const Icon(Icons.close, color: Colors.white),
                onPressed: () => Navigator.pop(context),
              ),
            ),
          ),
          Align(
            alignment: Alignment.bottomCenter,
            child: Padding(
              padding: const EdgeInsets.only(bottom: 60),
              child: GestureDetector(
                onTap: isTakingPicture ? null : () async {
                  try {
                    setState(() => isTakingPicture = true);
                    final image = await controller.takePicture();
                    if (!mounted) return;

                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => FrameSelectionScreen(imagePath: image.path),
                      ),
                    ).then((_) => setState(() => isTakingPicture = false));
                  } catch (e) {
                    setState(() => isTakingPicture = false);
                  }
                },
                child: Container(
                  height: 80,
                  width: 80,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    border: Border.all(color: Colors.white, width: 5),
                    color: isTakingPicture ? Colors.grey : Colors.white.withOpacity(0.5),
                  ),
                  child: isTakingPicture
                      ? const Padding(padding: EdgeInsets.all(20), child: CircularProgressIndicator(color: Colors.black))
                      : null,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

// --- SCREEN 2: EDITOR SCREEN ---
class FrameSelectionScreen extends StatefulWidget {
  final String imagePath;
  const FrameSelectionScreen({super.key, required this.imagePath});

  @override
  State<FrameSelectionScreen> createState() => _FrameSelectionScreenState();
}

class _FrameSelectionScreenState extends State<FrameSelectionScreen> {
  ScreenshotController screenshotController = ScreenshotController();

  // Senarai frame mengikut nama fail dalam assets/frames/
  final List<String> frames = [
    'none',
    'classic_polaroid.png',
    'retro_wood.png',
    'floral_garden.png',
    'gold_elegance.png'
  ];

  String selectedFrame = 'none';
  bool isSending = false;

  Future<void> sendToTelegram() async {
    setState(() => isSending = true);
    try {
      final imageBytes = await screenshotController.capture();
      if (imageBytes != null) {
        final directory = await getTemporaryDirectory();
        final imageFile = File('${directory.path}/saku_output.png');
        await imageFile.writeAsBytes(imageBytes);

        // MASUKKAN TOKEN DAN ID ANDA
        const String botToken = "8077767241:AAH7jZuswG9gPHhd18ujswOTHyegGrtobq0";
        const String chatId = "295548079";

        final url = Uri.parse('https://api.telegram.org/bot$botToken/sendPhoto');
        var request = http.MultipartRequest('POST', url);
        request.fields['chat_id'] = chatId;
        request.fields['caption'] = "New Saku Legacy Magnet Order! 📸🧲";
        request.files.add(await http.MultipartFile.fromPath('photo', imageFile.path));

        var response = await request.send();
        if (response.statusCode == 200) {
          if (!mounted) return;
          _showSuccessDialog();
        } else {
          throw "Telegram Error: ${response.statusCode}";
        }
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text("Error: $e")));
    } finally {
      if (mounted) setState(() => isSending = false);
    }
  }

  void _showSuccessDialog() {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) => AlertDialog(
        title: const Text("Berjaya! ✅"),
        content: const Text("Gambar anda telah dihantar ke printer. Sila ambil magnet anda sebentar lagi."),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).popUntil((route) => route.isFirst),
            child: const Text("OK"),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Customize Magnet"), centerTitle: true),
      body: Column(
        children: [
          Expanded(
            child: Center(
              child: Screenshot(
                controller: screenshotController,
                child: AspectRatio(
                  aspectRatio: 3 / 4,
                  child: Stack(
                    alignment: Alignment.center,
                    children: [
                      Image.file(File(widget.imagePath), fit: BoxFit.cover, width: double.infinity, height: double.infinity),
                      if (selectedFrame != 'none')
                        Image.asset('assets/frames/$selectedFrame', fit: BoxFit.fill, width: double.infinity, height: double.infinity),
                    ],
                  ),
                ),
              ),
            ),
          ),
          const Padding(
            padding: EdgeInsets.symmetric(vertical: 10),
            child: Text("Choose your frame"),
          ),
          Container(
            height: 100,
            margin: const EdgeInsets.only(bottom: 20),
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              padding: const EdgeInsets.symmetric(horizontal: 10),
              itemCount: frames.length,
              itemBuilder: (context, index) {
                return GestureDetector(
                  onTap: () => setState(() => selectedFrame = frames[index]),
                  child: Container(
                    width: 80,
                    margin: const EdgeInsets.symmetric(horizontal: 8),
                    decoration: BoxDecoration(
                      border: Border.all(color: selectedFrame == frames[index] ? Colors.amber : Colors.white12, width: 2),
                      borderRadius: BorderRadius.circular(15),
                      color: Colors.white10,
                    ),
                    child: Center(
                      child: Text(
                        frames[index].split('.').first.toUpperCase(),
                        style: const TextStyle(fontSize: 10, fontWeight: FontWeight.bold),
                        textAlign: TextAlign.center,
                      ),
                    ),
                  ),
                );
              },
            ),
          ),
          Padding(
            padding: const EdgeInsets.fromLTRB(25, 0, 25, 40),
            child: ElevatedButton(
              style: ElevatedButton.styleFrom(
                minimumSize: const Size(double.infinity, 60),
                backgroundColor: Colors.blueAccent,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(30)),
              ),
              onPressed: isSending ? null : sendToTelegram,
              child: isSending
                  ? const CircularProgressIndicator(color: Colors.white)
                  : const Text("SEND TO PRINT", style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.white)),
            ),
          ),
        ],
      ),
    );
  }
}
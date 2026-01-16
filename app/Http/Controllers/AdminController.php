<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalRooms'    => Room::count(),
            'totalBookings' => Booking::count(),
            'totalUsers'    => User::count(),
            'recentBookings'=> Booking::latest()->take(5)->get(),
            'rooms'         => Room::latest()->take(8)->get(),
        ]);
    }

    public function rooms()
    {
        return view('admin.rooms.index', [
            'rooms' => Room::paginate(10),
        ]);
    }

    public function bookings()
    {
        return view('admin.bookings.index', [
            'bookings' => Booking::whereIn('status', ['aktif', 'tidak_aktif'])->latest()->paginate(10),
        ]);
    }

    public function bookingHistory()
    {
        return view('admin.bookings.history', [
            'bookings' => Booking::where('status', 'selesai')->latest()->paginate(10),
        ]);
    }

    public function users()
    {
        return view('admin.users.index', [
            'users' => User::paginate(10),
        ]);
    }

    public function createRoom()
    {
        return view('admin.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|unique:rooms,name|max:50',
            'type'            => 'required|string|max:50',
            'price_per_night' => 'required|numeric|min:0',
            'capacity'        => 'required|integer|min:1|max:10',
            'description'     => 'nullable|string|max:1000',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120',
            'is_active'       => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            
            // Generate nama file unik dengan format JPEG
            $filename = time() . '_' . uniqid() . '.jpg';
            $storagePath = storage_path('app/public/rooms');
            
            // Buat folder jika belum ada
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            
            $fullPath = $storagePath . '/' . $filename;
            
            // Konversi dan optimasi foto ke JPEG menggunakan GD
            $this->convertAndOptimizeImage($file->getRealPath(), $fullPath);
            
            $validated['photo'] = 'rooms/' . $filename;
        }

        Room::create($validated);

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function editRoom(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function updateRoom(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:50|unique:rooms,name,' . $room->id,
            'type'            => 'required|string|max:50',
            'price_per_night' => 'required|numeric|min:0',
            'capacity'        => 'required|integer|min:1|max:10',
            'description'     => 'nullable|string|max:1000',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120',
            'is_active'       => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.jpg';
            $storagePath = storage_path('app/public/rooms');

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $fullPath = $storagePath . '/' . $filename;
            $this->convertAndOptimizeImage($file->getRealPath(), $fullPath);

            if ($room->photo) {
                $oldPhotoPath = storage_path('app/public/' . $room->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $validated['photo'] = 'rooms/' . $filename;
        }

        $room->update($validated);

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Kamar berhasil diperbarui!');
    }

    public function deleteRoom(Room $room)
    {
        if ($room->photo) {
            $photoPath = storage_path('app/public/' . $room->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $room->delete();

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Kamar berhasil dihapus!');
    }

    /**
     * Konversi gambar apapun ke JPEG dan optimasi untuk web
     */
    private function convertAndOptimizeImage($sourcePath, $destinationPath, $maxWidth = 1200, $quality = 85)
    {
        // Deteksi tipe gambar
        $imageInfo = getimagesize($sourcePath);
        $mimeType = $imageInfo['mime'];
        
        // Buat resource gambar sesuai tipe
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            case 'image/bmp':
            case 'image/x-ms-bmp':
                $image = imagecreatefrombmp($sourcePath);
                break;
            default:
                throw new \Exception('Format gambar tidak didukung');
        }
        
        // Dapatkan dimensi asli
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);
        
        // Hitung dimensi baru (resize jika lebih besar dari maxWidth)
        if ($originalWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = intval(($originalHeight / $originalWidth) * $maxWidth);
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }
        
        // Buat gambar baru dengan dimensi yang sudah dioptimasi
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Set background putih untuk gambar transparan
        $white = imagecolorallocate($newImage, 255, 255, 255);
        imagefill($newImage, 0, 0, $white);
        
        // Resize dengan kualitas tinggi
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        
        // Simpan sebagai JPEG dengan kualitas optimal
        imagejpeg($newImage, $destinationPath, $quality);
        
        // Bersihkan memory
        imagedestroy($image);
        imagedestroy($newImage);
    }

    /**
     * Update status booking
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:aktif,tidak_aktif,selesai',
        ]);

        $updates = $validated;
        if ($validated['status'] === 'aktif') {
            $updates['payment_status'] = 'paid';
            $updates['paid_at'] = now();
        }

        $booking->update($updates);

        return redirect()
            ->route('admin.bookings')
            ->with('success', 'Status booking berhasil diperbarui!');
    }
}
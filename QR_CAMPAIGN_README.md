# M&M QR Code Campaign System

A complete QR code campaign management system for M&M brand, allowing customers to scan unique QR codes and win exciting gifts.

## Features

### Admin Panel
- **Gift Management**: Full CRUD operations for managing gifts (Spa Ceylon Gift Vouchers, Shagila Dinner Vouchers, etc.)
- **QR Code Management**: Generate, view, edit, and download unique QR codes
- **Batch Generation**: Create up to 200 QR codes at once (perfect for M&M packets)
- **Tracking**: View scan status, customer details, and redemption history
- **Gift Assignment**: Assign specific gifts to QR codes during creation

### Public Features
- **QR Code Scanning**: Customers scan QR codes to access the campaign
- **User Registration**: Collect name, email, and phone number
- **Gift Reveal**: Beautiful gift reveal page after form submission
- **One-Time Use**: Each QR code can only be scanned once
- **Mobile Responsive**: Works perfectly on all devices

## Installation

The system is already set up! Here's what was done:

1. ✅ Database migrations created and run
2. ✅ Models created (Gift, QRCode, Scan)
3. ✅ Controllers implemented
4. ✅ Routes configured
5. ✅ Admin views created
6. ✅ Public views created
7. ✅ QR code library installed
8. ✅ Sample gifts seeded

## Getting Started

### 1. Access Admin Panel

Login to the admin panel:
- URL: `http://your-domain.com/admin/login`
- Email: `admin@example.com`
- Password: `password`

### 2. Manage Gifts

Navigate to **Gifts** in the admin sidebar:
- View all gifts
- Create new gifts with:
  - Name (e.g., "Spa Ceylon Gift Voucher")
  - Type (e.g., "voucher", "dinner")
  - Value (optional)
  - Description
  - Active/Inactive status

### 3. Generate QR Codes

Navigate to **QR Codes** in the admin sidebar:
1. Click "Generate QR Codes"
2. Select a gift to assign
3. Enter quantity (1-200 for M&M packets)
4. Add batch number (optional, for organization)
5. Click "Generate QR Codes"

### 4. Download QR Codes

Two ways to download QR codes:
1. **Individual**: Click "Download" next to any QR code in the list
2. **View & Download**: Click on a QR code to view details, then download

The QR codes are generated as PNG images (300x300px) ready for printing on M&M packet stickers.

### 5. Customer Experience

When a customer scans a QR code:
1. They're redirected to: `http://your-domain.com/qr/{CODE}`
2. A beautiful form asks for:
   - Full Name
   - Email Address
   - Phone Number
3. After submission, they see their winning gift
4. The QR code is marked as "scanned" and cannot be used again

## Database Structure

### Gifts Table
- `id`: Primary key
- `name`: Gift name
- `description`: Gift description
- `type`: Gift type/category
- `value`: Monetary value (optional)
- `is_active`: Active status
- `timestamps`: Created/Updated dates

### QR Codes Table
- `id`: Primary key
- `code`: Unique QR code (auto-generated as MM-XXXXXXXXXX)
- `gift_id`: Foreign key to gifts table
- `is_scanned`: Scan status
- `scanned_at`: Scan timestamp
- `batch_number`: Optional batch identifier
- `timestamps`: Created/Updated dates

### Scans Table
- `id`: Primary key
- `qr_code_id`: Foreign key to qr_codes table
- `name`: Customer name
- `email`: Customer email
- `phone`: Customer phone
- `ip_address`: Customer IP (for tracking)
- `timestamps`: Created/Updated dates

## API Routes

### Public Routes
```
GET  /qr/{code}  - Show QR scan form
POST /qr/{code}  - Submit form and reveal gift
```

### Admin Routes (Protected)
```
GET    /admin/login          - Show login form
POST   /admin/login          - Process login
POST   /admin/logout         - Logout
GET    /admin/dashboard      - Dashboard

# Gifts
GET    /admin/gifts          - List all gifts
GET    /admin/gifts/create   - Show create form
POST   /admin/gifts          - Store new gift
GET    /admin/gifts/{id}     - Show gift details
GET    /admin/gifts/{id}/edit - Show edit form
PUT    /admin/gifts/{id}     - Update gift
DELETE /admin/gifts/{id}     - Delete gift

# QR Codes
GET    /admin/qrcodes               - List all QR codes
GET    /admin/qrcodes/create        - Show create form
POST   /admin/qrcodes               - Generate QR codes
GET    /admin/qrcodes/{id}          - Show QR code details
GET    /admin/qrcodes/{id}/edit     - Show edit form
PUT    /admin/qrcodes/{id}          - Update QR code
DELETE /admin/qrcodes/{id}          - Delete QR code
GET    /admin/qrcodes/{id}/download - Download QR code image
```

## Usage Examples

### Example 1: Creating Gifts
```php
// In admin panel or via tinker
Gift::create([
    'name' => 'Spa Ceylon Gift Voucher',
    'description' => 'Premium spa experience',
    'type' => 'voucher',
    'value' => 100.00,
    'is_active' => true,
]);
```

### Example 2: Generating QR Codes Programmatically
```php
// Generate 200 QR codes for a batch
for ($i = 1; $i <= 200; $i++) {
    QRCode::create([
        'gift_id' => 1, // Spa Ceylon Gift
        'batch_number' => 'BATCH-001',
    ]);
}
```

### Example 3: Checking Scan Status
```php
$qrCode = QRCode::where('code', 'MM-ABC123XYZ')->first();

if ($qrCode->is_scanned) {
    echo "Already claimed on {$qrCode->scanned_at}";
} else {
    echo "Available to claim";
}
```

## Customization

### Changing QR Code Format
Edit `app/Models/QRCode.php`, method `generateUniqueCode()`:
```php
public static function generateUniqueCode()
{
    do {
        // Change 'MM-' prefix and length as needed
        $code = 'CUSTOM-' . strtoupper(Str::random(12));
    } while (self::where('code', $code)->exists());
    
    return $code;
}
```

### Changing QR Code Size
Edit download method in `app/Http/Controllers/Admin/AdminQRCodeController.php`:
```php
// Change size from 300 to your preferred size
echo \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
    ->size(500) // Change this
    ->generate($url);
```

### Customizing Public Pages
Edit the views in `resources/views/qr/`:
- `form.blade.php` - Registration form
- `reveal.blade.php` - Gift reveal page
- `already-scanned.blade.php` - Already claimed page

## Reporting & Analytics

### View Statistics via Tinker
```php
// Total QR codes generated
QRCode::count();

// Scanned QR codes
QRCode::where('is_scanned', true)->count();

// Available QR codes
QRCode::where('is_scanned', false)->count();

// Scans by gift type
Scan::with('qrCode.gift')->get()
    ->groupBy('qrCode.gift.type')
    ->map->count();

// Recent scans
Scan::with(['qrCode.gift'])
    ->latest()
    ->take(10)
    ->get();
```

## Security Features

- ✅ Admin authentication required for management
- ✅ CSRF protection on all forms
- ✅ Unique QR code validation
- ✅ One-time use enforcement
- ✅ IP address tracking
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade templating)

## Support

For issues or questions:
1. Check the QR code reference number
2. Review scan logs in the admin panel
3. Check customer details in the Scans table

## Sample Workflow

1. **Setup Phase**
   - Admin logs in
   - Creates 2 gift types (Spa Ceylon, Shagila Dinner)
   
2. **Production Phase**
   - Generate 200 QR codes for Batch-001 (100 Spa, 100 Dinner)
   - Download all QR codes
   - Print on M&M packet stickers
   
3. **Distribution Phase**
   - M&M packets distributed to customers
   - Customers scan QR codes
   - System collects customer data
   - Gift revealed instantly
   
4. **Fulfillment Phase**
   - Admin reviews scans
   - Contacts customers using collected info
   - Delivers/redeems gifts

## Technical Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Inline CSS
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **QR Code Library**: SimpleSoftwareIO/simple-qrcode
- **Authentication**: Laravel built-in authentication

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── Admin/
│       │   ├── AdminGiftController.php
│       │   └── AdminQRCodeController.php
│       └── QRScanController.php
├── Models/
│   ├── Gift.php
│   ├── QRCode.php
│   └── Scan.php

database/
├── migrations/
│   ├── *_create_gifts_table.php
│   ├── *_create_qr_codes_table.php
│   └── *_create_scans_table.php

resources/
└── views/
    ├── admin/
    │   ├── gifts/
    │   │   ├── index.blade.php
    │   │   ├── create.blade.php
    │   │   ├── edit.blade.php
    │   │   └── show.blade.php
    │   └── qrcodes/
    │       ├── index.blade.php
    │       ├── create.blade.php
    │       ├── edit.blade.php
    │       └── show.blade.php
    └── qr/
        ├── form.blade.php
        ├── reveal.blade.php
        └── already-scanned.blade.php
```

## License

This campaign system is proprietary to M&M brand.

---

**Ready to launch your QR code campaign!** 🎉










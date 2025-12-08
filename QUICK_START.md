# M&M QR Campaign - Quick Start Guide

## ✅ System is Ready!

Everything has been set up for your M&M QR code campaign system.

## 🚀 Get Started in 3 Steps

### Step 1: Start Your Development Server
```bash
php artisan serve
```

Your application will be available at: `http://localhost:8000`

### Step 2: Login to Admin Panel
1. Visit: `http://localhost:8000/admin/login`
2. Email: `admin@example.com`
3. Password: `password`

### Step 3: Generate Your First QR Codes
1. In the admin panel, click **"Gifts"** in the sidebar
2. You'll see 2 pre-loaded gifts:
   - Spa Ceylon Gift Voucher
   - Shagila Dinner Voucher
3. Click **"QR Codes"** in the sidebar
4. Click **"+ Generate QR Codes"**
5. Select a gift, enter quantity (e.g., 10 for testing, 200 for production)
6. Click **"Generate QR Codes"**

## 📱 Test the Customer Experience

After generating QR codes:
1. Go to **QR Codes** list in admin
2. Click on any QR code to view details
3. Copy the scan URL (e.g., `http://localhost:8000/qr/MM-XXXXXXXXXX`)
4. Open it in a new browser window (or on your phone)
5. Fill in the form with test data
6. See the beautiful gift reveal page!
7. Try scanning the same code again - you'll see it's already claimed

## 🎨 What You Can Do

### In Admin Panel:
- ✅ **Create/Edit/Delete Gifts**
  - Add new gift types
  - Set gift values
  - Activate/Deactivate gifts

- ✅ **Generate QR Codes**
  - Bulk generate up to 200 codes
  - Assign to specific gifts
  - Organize by batch numbers

- ✅ **Download QR Codes**
  - Individual QR code download as PNG
  - 300x300px high quality
  - Ready to print on stickers

- ✅ **Track Everything**
  - See which codes are scanned
  - View customer details (name, email, phone)
  - Check redemption dates
  - Monitor campaign performance

### For Customers:
- ✅ Scan QR code from M&M packet
- ✅ Fill registration form (name, email, phone)
- ✅ Instantly see their winning gift
- ✅ Get reference code for verification

## 📊 View Campaign Statistics

Open terminal and run:
```bash
php artisan tinker
```

Then run these commands:

```php
// Total QR codes generated
\App\Models\QRCode::count();

// How many have been scanned
\App\Models\QRCode::where('is_scanned', true)->count();

// Available codes
\App\Models\QRCode::where('is_scanned', false)->count();

// All customer submissions
\App\Models\Scan::with('qrCode.gift')->get();

// Exit tinker
exit
```

## 🖨️ Print QR Codes for M&M Packets

1. Go to **Admin Panel > QR Codes**
2. For each QR code:
   - Click the code to view details
   - Click **"Download QR Code"** button
   - Save the PNG file
3. Print codes on sticker sheets
4. Stick 200 unique codes per M&M packet batch

## 🎯 Production Workflow

### Before Launch:
1. Create your gift types (Spa Ceylon, Shagila Dinner)
2. Generate 200 QR codes per batch
3. Assign appropriate gifts to codes
4. Download all codes
5. Print on stickers
6. Apply to M&M packets

### During Campaign:
1. Customers scan codes
2. System automatically:
   - Collects customer data
   - Marks code as used
   - Shows winning gift
3. Monitor in admin panel

### After Scanning:
1. Review customer list in admin
2. Contact customers via email/phone
3. Arrange gift delivery/redemption
4. Use reference codes for verification

## 🔐 Security Notes

- Each QR code can only be scanned **once**
- Admin panel requires authentication
- Customer data is securely stored
- IP addresses tracked for fraud prevention

## 📝 Sample Gift Types

Already included:
- **Spa Ceylon Gift Voucher**: $100 value, Spa experience
- **Shagila Dinner Voucher**: $150 value, Fine dining for 2

Add more gifts as needed!

## 🆘 Need Help?

1. Check `QR_CAMPAIGN_README.md` for detailed documentation
2. All code is well-commented
3. Admin panel is intuitive and user-friendly

## 🎉 Ready to Launch!

Your M&M QR code campaign system is fully functional and ready for production use.

**Start your server and login to begin:** `php artisan serve`

---

*Happy campaigning! 🎊*


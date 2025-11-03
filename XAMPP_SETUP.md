# XAMPP Setup for midterm.local

## Step 1: Configure Apache Virtual Host

1. Open XAMPP Control Panel
2. Click "Config" button next to Apache
3. Select "httpd-vhosts.conf"
4. Add the following configuration at the end of the file:

```apache
<VirtualHost *:80>
    ServerName midterm.local
    DocumentRoot "C:/xampp/htdocs/MidTerm230100575/public"
    <Directory "C:/xampp/htdocs/MidTerm230100575/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Note**: Make sure the path `C:/xampp/htdocs/MidTerm230100575/public` matches your actual project path.

## Step 2: Edit Hosts File

1. Open Notepad as Administrator (Right-click → Run as administrator)
2. Open file: `C:\Windows\System32\drivers\etc\hosts`
3. Add this line at the end:
```
127.0.0.1    midterm.local
```
4. Save the file

## Step 3: Restart Apache

1. In XAMPP Control Panel
2. Stop Apache
3. Start Apache again

## Step 4: Update Laravel .env (if needed)

If you have a `.env` file, you might want to update the `APP_URL`:

```
APP_URL=http://midterm.local
```

Or you can skip this step - Laravel will work fine without it.

## Step 5: Test

Visit: `http://midterm.local/`

You should see your Laravel application!

---

## Troubleshooting

### Issue: "403 Forbidden" or "Access Denied"
- Check that the DocumentRoot path in httpd-vhosts.conf is correct
- Make sure the path uses forward slashes `/` or escaped backslashes `\\`
- Verify the `public` folder exists

### Issue: "This site can't be reached"
- Check hosts file was saved correctly
- Make sure you edited hosts file as Administrator
- Try flushing DNS: Open Command Prompt as Admin → `ipconfig /flushdns`

### Issue: Still shows old site or error
- Clear browser cache
- Try in incognito/private window
- Restart Apache multiple times

### Issue: Virtual host not working
- Make sure `httpd-vhosts.conf` is included in main `httpd.conf`:
  - Look for: `Include conf/extra/httpd-vhosts.conf`
  - It should NOT be commented out (no `#` at the start)

---

## Alternative: Quick Setup Script

If you prefer, you can manually:
1. Copy the virtual host config above
2. Add to hosts file
3. Restart Apache

That's it! 🚀


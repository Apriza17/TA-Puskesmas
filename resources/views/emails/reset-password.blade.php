<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - SIM-POSDA</title>
</head>
<body style="margin:0; padding:0; background-color:#f2f2f2;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f2f2f2;">
        <tr>
            <td align="center" style="padding:30px 0;">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#0E8FB2; padding:25px 10px;">
                            <img src="img/logo.png" alt="SIM-POSDA" style="height:60px; margin-bottom:10px;">
                            <h1 style="color:#ffffff; font-size:20px; font-weight:bold; margin:0;">Memperbarui Password</h1>
                            <p style="color:#ffffff; font-size:14px; margin:0;">Puskesmas Gunung Sari Ulu</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td align="center" style="padding:40px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:500px;">
                                <tr>
                                    <td align="center" style="background:#ffffff; border-radius:10px; padding:30px; box-shadow:0 3px 8px rgba(0,0,0,0.1);">
                                        <h2 style="color:#333333; margin-bottom:10px;">Halo!</h2>
                                        <p style="color:#555555; font-size:14px; line-height:22px; margin-bottom:25px;">
                                            Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun Anda.
                                        </p>

                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td align="center" bgcolor="#3FA1A9" style="border-radius:5px;">
                                                    <a href="{{ $url }}"
                                                        style="display:inline-block; padding:10px 20px; color:#ffffff; background-color:#3FA1A9; border-radius:5px; text-decoration:none; font-weight:bold;">
                                                        Perbarui Password
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin-top:15px; font-size:12px; color:#888888;">*Klik tombol untuk memperbarui</p>

                                        <p style="color:#555555; font-size:13px; margin-top:25px;">
                                            Email akan kedaluwarsa dalam <strong>60 menit</strong>.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f8f8f8; padding:15px;">
                            <p style="font-size:12px; color:#999999; margin:0;">
                                &copy; {{ date('Y') }} SIM-POSDA | Puskesmas Gunung Sari Ulu
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

Password Reset Request

Hello {{ $notifiable->name ?? 'User' }},

You are receiving this email because we received a password reset request for your account.

To reset your password, please click on the link below or copy and paste it into your web browser:

{{ $url }}

IMPORTANT: This password reset link will expire in {{ $expireTime }} minutes.

If you did not request a password reset, no further action is required. Your password will remain unchanged.

For security reasons, please do not share this email with anyone.

Best regards,
The {{ config('app.name') }} Team

---

© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.

If you're having trouble with the link above, copy and paste this URL into your web browser:
{{ $url }}

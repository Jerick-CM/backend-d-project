<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <style>
    /* cyrillic-ext */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFWJ0bf8pkAp6a.woff2) format('woff2');
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
    }
    /* cyrillic */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFUZ0bf8pkAp6a.woff2) format('woff2');
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }
    /* greek-ext */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFWZ0bf8pkAp6a.woff2) format('woff2');
    unicode-range: U+1F00-1FFF;
    }
    /* greek */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFVp0bf8pkAp6a.woff2) format('woff2');
    unicode-range: U+0370-03FF;
    }
    /* vietnamese */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFWp0bf8pkAp6a.woff2) format('woff2');
    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
    }
    /* latin-ext */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFW50bf8pkAp6a.woff2) format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    /* latin */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v15/mem8YaGs126MiZpBA-UFVZ0bf8pkAg.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    /* cyrillic-ext */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOX-hpKKSTj5PW.woff2) format('woff2');
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
    }
    /* cyrillic */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOVuhpKKSTj5PW.woff2) format('woff2');
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }
    /* greek-ext */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXuhpKKSTj5PW.woff2) format('woff2');
    unicode-range: U+1F00-1FFF;
    }
    /* greek */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOUehpKKSTj5PW.woff2) format('woff2');
    unicode-range: U+0370-03FF;
    }
    /* vietnamese */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXehpKKSTj5PW.woff2) format('woff2');
    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
    }
    /* latin-ext */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOXOhpKKSTj5PW.woff2) format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    /* latin */
    @font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 700;
    src: local('Open Sans Bold'), local('OpenSans-Bold'), url(https://fonts.gstatic.com/s/opensans/v15/mem5YaGs126MiZpBA-UN7rgOUuhpKKSTjw.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    body {
        color: #444;
        font-size: 16px;
        line-height: normal;
        font-family: 'Open Sans', Arial, sans-serif;
    }
    .logo {
        width: 300px;
    }
    h1, .title {
        color: #000;
    }
    h1, p {
        margin-bottom: 16px;
    }
    h1 {
        font-size: 1.5rem;
    }
    .message-container {
        width: 600px;
        padding: 4px 0;
        margin-bottom: 32px;
        background-color: #e0e0e0;
    }
    .message {
        width: 333px;
        padding: 15px;
        margin: 0 auto;
        background-color: #fff;
    }
    .message .message-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #bdbdbd;
    }
    .message .message-header img.avatar,
    .message .message-header div.details {
        display: inline-block;
        vertical-align: middle;
    }
    .message .message-header img.avatar {
        width: 60px;
        height: 60px;
        border-radius: 100%;
    }
    .message .message-header div.details {
        margin-left: 10px;
    }
    .message .message-header div.details .details-name {
        font-weight: 700;
        font-size: 1.25rem;
        text-overflow: ellipsis;
    }
    .message img.badge {
        width: 200px;
        margin: 0 auto;
        display: block;
    }
    .message .badge-name {
        margin-top: 8px;
        margin-bottom: 16px;
        font-size: 17px;
        font-weight: 700;
        text-align: center;
        text-transform: uppercase;
    }
    .message .message-content {
        margin-bottom: 16px;
        color: #000;
        font-size: 0.875rem;
    }
    .message .message-footer {
        color: #a9a9a9;
        font-size: 0.875rem;
    }
    .message .message-footer .footer-name {
        font-weight: 700;
    }
    .sig-btn {
        padding: 8px 16px;
        color: #FFF;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        background-color: #8BAF3E;
        border-bottom: 3px solid #6A8337;
    }
    strong {
        font-weight: 700;
    }
    .web-preview {
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.875rem;
        background-color: #f0f0f0;
    }
    </style>
</head>
<body>
    <div class="web-preview">
        Having trouble opening this email? Click
        <a href="{{ $webPreviewLink }}" target="_blank">here</a>
    </div>
    <img src="{{ secure_url('img/logo.jpg') }}" alt="logo" class="logo">
    <h1>You Received a Message!</h1>
    <p class="title">
        Dear {{ $user->name }},
    </p>
    <p>
        <div>This email is to notify you that you received a message from <strong>{{ $sender->name }}</strong></div>    
        <div>See the message details below</div>
    </p>
    <div class="message-container">
        <div class="message">
            <div class="message-header">
                <img src="{{ $user->avatar }}" alt="avatar" class="avatar">
                <div class="details">
                    <div class="details-name">{{ $user->name }}</div>
                    <div class="details-position">{{ $user->position_name }}</div>
                </div>
            </div>
            <img src="{{ $badge->image_url }}" alt="badge" class="badge">
            <div class="badge-name">{{ $badge->name }}</div>
            <div class="message-content">{{ $messageContent }}</div>
            <div class="message-footer">
                <div class="footer-name">From {{ $sender->name }}</div>
                <div>{{ $date }} | {{ $time }}</div>
            </div>
        </div>
    </div>
    <a href="#" class="sig-btn">SEE YOUR MESSAGES AND MORE IN REWARDS PORTAL</a>
</body>
</html>
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
    table tr td {
        vertical-align: top;
    }
    table.order {
        border-collapse: collapse;
    }
    table.order thead th,
    table.order tbody td {
        padding: 4px 10px;
    }
    table.order thead th {
        color: #FFF;
        text-transform: uppercase;
        background-color: #000;
    }
    table.order tbody td {
        vertical-align: middle;
    }
    .order-details {
        margin-bottom: 16px;
    }
    .order-details .inventory-photo-td {
        max-width: 160px;
    }
    .order-details .inventory-photo {
        max-width: 100%;
    }
    strong {
        font-weight: 700;
    }
    .center {
        text-align: center;
    }
    .right {
        text-align: right;
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
    <h1>Order Confirmation</h1>
    <p class="title">
        Dear {{ $user->name }},
    </p>
    <p>
        This email is to confirm your order <strong>{{ $orderNumber }}</strong> on {{ $date }}
    </p>
    <div class="order-container">
        <table>
            <tr>
                <td>
                    <div class="order-details">
                        <table class="order">
                            <thead>
                                <th colspan="2">Item</th>
                                <th>Tokens</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                <tr>
                                    <td class="inventory-photo-td"><img src="{{ $item['inventory']->primary_photo->file }}" alt="inventory photo" class="inventory-photo"></td>
                                    <td>
                                        <strong>{{ $item['inventory']->name }}</strong>
                                    </td>
                                    <td class="center">{{ $item['tokens'] }}</td>
                                    <td class="center">{{ $item['quantity'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
                <td>
                    <div class="order-summary">
                        <table class="order">
                            <thead>
                                <th colspan="2">Order Summary</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Tokens:</td>
                                    <td class="right">{{ $totalTokens }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <a href="#" class="sig-btn">TRACK YOUR ORDERS IN REWARDS PORTAL</a>
    </div>
</body>
</html>
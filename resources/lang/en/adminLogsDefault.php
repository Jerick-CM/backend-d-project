<?php

return [
    '1000' => ':admin has transferred :amount "My Rewards" token to :user',
    '1001' => ':admin has deducted :amount "My Rewards" token from :user',

    '1010' => ':admin has transferred :amount "Recognise Others" token to :user',
    '1011' => ':admin has deducted :amount "Recognise Others" token from :user',

    '1100' => ':admin has increased the monthly token allowance of :position to :amount',
    '1101' => ':admin has decreased the monthly token allowance of :position to :amount',
    '1102' => ':admin has increased the maximum send token limit of :position to :amount',
    '1103' => ':admin has decreased the maximum send token limit of :position to :amount',

    '1300' => ':admin has updated the home page carousel with new Banner(s)',
    '1301' => ':admin has updated a link for the carousel banner at the home page',
    '1302' => ':admin has updated the home page carousel banner with a new title',
    '1303' => ':admin has updated the ACE Store carousel with new Banner(s)',
    '1304' => ':admin has updated a link for the carousel banner at the ACE Store',
    '1305' => ':admin has updated the ACE Store carousel banner with a new title',

    '1400' => ':admin has updated the inventory with a new product',
    '1401' => ':admin has updated a product name in the inventory',
    '1402' => ':admin has updated a product profile photo in the inventory',
    '1403' => ':admin has updated a product price in the inventory',
    '1404' => ':admin has updated a product as "discontinued" in the inventory',
    '1405' => ':admin has updated a product as "pre-order" in the inventory',
    '1406' => ':admin has updated the meta description for a product in the inventory',

    '1500' => ':admin has downloaded :type transaction record',
    
    '1510' => ':admin has downloaded :type record',

    //faq
    '2000' => ':admin has edited FAQ item `:title` with category `:category_name` .',
    '2001' => ':admin has added FAQ item    `:value` with category `:category_name` .',
    '2002' => ':admin has sorted FAQ item `:title` with category `:category_name` .',
    '2003' => ':admin has deleted FAQ item `:value` with category `:category_name` .',
    '2004' => ':admin has deleted multiple FAQ items :name_category.',

    //faq categories
    '2020' => ':admin has edited FAQ category `:item`.',
    '2021' => ':admin has added FAQ category `:value` .',
    '2022' => ':admin has sorted FAQ category `:category_name` .',
    '2023' => ':admin has deleted FAQ category `:value` .',
    '2024' => ':admin has has deleted multiple FAQ categories :name_category.',

    // '2024' => ':admin has used deleted multiple option FAQ category item title ` :category ` ',
    //faq file
    '2040' => ':admin has updated FAQ pdf file',

    //page menu
    '2050' => ':admin has edited  Menu page ` :menu ` ',
    '2051' => ':admin has added  Menu page  ` :menu ` ',    
    '2052' => ':admin has sorted Menu page  ` :data_name ` ',
    '2053' => ':admin has deleted Menu page ` :menu_name `',

    // '2054' => ':admin has used deleted multiple option page menu item - ` :menu_deleted `',
    '2054' => ':admin has has deleted multiple Menu page :name_category.',

    '2060' => ':admin has updated the post from " :old_message " to " :new_message " with sender `:from_message` and recipient `:to_message` ',


    '2068' => 'Admin - :admin has removed the message `:messages` .',
    '2069' => 'Admin - :admin has removed the badge `:badge_name` .',

    '2070' => 'Admin - :admin has removed the badge " :badge_name " with recipient  `:recipient_name`  and sender  `:sender_name`',
    '2071' => 'Admin - :admin has retained the badge  `:badge_name` with recipient  `:recipient_name`  and sender  `:sender_name`',


    '2072' => 'Admin - :admin has removed the token amount `:green_token` tokens with badge `:badge_name` with sender `:sender_name`  and  recipient `:recipient_name`   ',
    '2073' => 'Admin - :admin has retained the token amount `:green_token` tokens with badge `:badge_name`  with sender `:sender_name`  and  recipient `:recipient_name` ',
    
    '2074' => 'Admin - :admin has refunded to  " :sender_name " tokens from " :black_token_before " to " :black_token_after " from sender ` :sender_name ` and recipient `:recipient_name` badge name `:badge_name` ',

    '2075' => 'Admin - :admin has updated tier from `:tier_old` to `:tier_new` with recipient `:recipient_name` and sender `:sender_name` of badge `:badge_name` ',

   '2076' => 'Admin - :admin an event and granted promotion from `:tier_old` to  `:tier_new` badge `:badge_name` with sender `:sender_name` and recipient `:recipient_name` , from `:green_token_before` to `:green_token_after` tokens , recipient has been awarded `:rewardtoken`  tokens .',

    '2077'  =>'Admin - :admin has updated the reward token for `:rewardstoken_description` from `:rewardstoken_old` token/s to `:rewardstoken_new` token/s. ',


    '2080'  =>':admin has edited edm footer. ',
    '2081'  =>':admin has edited edm header. ',
    '2082'  =>':admin has edited edm body message of `:label` ',

    '2083'  =>'E-mail has been sent from `:sender_name` to `:receiver_name` via EDM `:email_category` ',
    '2084'  =>'E-mail has been received  by `:receiver_name` from `:sender_name` via EDM `:email_category` ',
    '2085'  =>'The System has sent  received  by `:receiver_name` `:email_category` ',
    '2086'  =>'EDM Checkout has been used by `:receiver_name`',
    '2087'  =>'EDM Monthly report is sent to `:receiver_name`',
    '2088'  =>'EDM Tier Promotion has been awarded to `:receiver_name` from `:tier_old` to `:tier_new` ',    
    '2089'  =>':admin has created edm template body. ',
    '2090'  =>':admin has deleted edm body message of `:label`',
    '2091'  =>':admin has downloaded edm send logs',
    '2092'  =>':admin implemented mass token upload with message `:message` to user `:user_name`',

    '2093'  =>':admin report generation e-mail is sent with message `:message` ',
];

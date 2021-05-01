<?php
use App\Http\Controllers\BotManController;
use App\Proposal;

$botman = resolve('botman');


$botman->hears('/start|GET_STARTED', function ($bot) {
    $bot->reply('Let\'s go together and became stronger! 💪');
    $bot->reply('by 🚙 or 🚆 or ✈ to 🧗🤸');
});

$botman->hears('show', function ($bot) {
    $proposals = Proposal::all();
    $bot->reply('Your events are:');

    foreach ($proposals as $proposal) {
        $keyboard = \BotMan\Drivers\Telegram\Extensions\Keyboard::create()->addRow(
            \BotMan\Drivers\Telegram\Extensions\KeyboardButton::create("go")->callbackData('letsgo')
        );
        $bot->reply($proposal->title, $keyboard->toArray());
    }
});

$botman->hears('add {title}', function ($bot, $title) {
   Proposal::create([
       'title' => $title,
       'user_id' => $bot->getMessage()->getSender()
   ]);

   $bot->reply("You are added new event \"" . $title . "\"");
});

$botman->hears('letsgo', function ($bot) {
    $bot->reply('GO!');
});

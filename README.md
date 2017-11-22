# Blazing

## Telegram bot php SDK

* Installing
	* [Install php](http://php.net/manual/en/install.php) (7.0 or higher recommend)
	* [Install composer](https://getcomposer.org/doc/00-intro.md)

* Create a new project
	* In terminal (cmd) run 
	`composer create-project blaze/blazingsdk <project-name>`
	* Wait till all dependencies are installed

* Create a new Bot
	* Go to project folder ( `cd <project-name>` )
	* `composer new bot <bot-name> <bot-api-token>`
	* A new folder with the bot name inside project folder should be created now.

* (optional) using laravel’s database module (eloquent) with bots
	* Refer to [How to use eloquent outside laravel](https://laracasts.com/lessons/how-to-use-eloquent-outside-of-laravel)
	* An easier was to use eloquent is planned for future.

* At this point bot will be already configured to respond to /start and /help commands with some default response. You can edit these response from `commands.php` file inside your bot's directory

* To add support for more commands add a new method to Commands class (`commands.php` file). The method should be static (will be changed later) and method name should be the first word of the command. The method should also accept 2 arguments a bot object and a message object.
	* Eg: if you are adding support for `/hello` command your method should look like 
		* `public static function hello(Bot $bot, Message $msg) {  }`

	* Note a command doesn't necessarily have to be in the beginning of a msg to be sent to `commands.php`. you can change this from `updates.php`

* If you want bot to respond to CallBackQueries you have add a method to CallBackQueries class (`CallBackQueries.php` file). The method should be static and its name should be the first word of callback query’s data. The method should also accept 2 arguments, a bot object and a CallBackQuery object.
	* Eg: if you are adding support for a call back query with first word of data as 'hello' your method should look like 
		* `public static function hello(Bot $bot, CallBackQuery $cbq) {  }`

	* You can also edit `updates.php` file to customize the way you want to handle commands, CallBackQueries and other types of bot update objects.

* For the telegram api objects (Message, chat user etc…) use `get` before api method as getters.
	* Eg: to get message id, use `$msg->getMessageId()`
	* Case sentivity and underscores doesn't matter.

* To send requests to telegram api use sendRequest() method in bot class. This method accepts an array. The array must contain a method key and other parameters for the specified method.
	* Eg: `$bot->sendRequest (array(
                         “method” => “sendMessage”,
                         “chat_id” => $msg->getChat()->getId(),
                         “text” => “some text”
                    ));`
                    

##### If you need any further assistance please do not hesitate to contact me (@BlazeMV) on telegram.





###### Developed with php  by Adam Dawood (@BlazeMV)

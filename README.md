---


---

<h1 id="php-yandex-alisa">PHP-YANDEX-ALISA</h1>
<p>Библиотека для работы с Алисой.</p>
<hr>
<h2 id="содержание">Содержание</h2>
<ol>
<li><a href="#todo">TODO</a></li>
<li><a href="#%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0">Установка</a></li>
<li><a href="#%D0%9E%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BA%D0%BE%D0%BD%D1%81%D1%82%D0%B0%D0%BD%D1%82">Описание констант</a></li>
<li><a href="#%D0%9E%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BF%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D1%8B%D1%85">Описание переменных</a></li>
<li><a href="#%D0%9E%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BC%D0%B5%D1%82%D0%BE%D0%B4%D0%BE%D0%B2">Описание методов</a></li>
<li><a href="#indexphp">index.php</a></li>
<li><a href="#%D0%9B%D0%BE%D0%BA%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9-webhook">Локальный Webhook.</a></li>
</ol>
<hr>
<h2 id="todo">TODO</h2>

<table>
<thead>
<tr>
<th>Дата</th>
<th>Описание релиза</th>
<th>Состояние</th>
</tr>
</thead>
<tbody>
<tr>
<td>5.08.2018</td>
<td>Теперь можно делать вариации вопросов и ответов.</td>
<td><strong>done</strong></td>
</tr>
<tr>
<td>5.08.2018</td>
<td>Выполнять payload-функции (callback).</td>
<td><strong>done</strong></td>
</tr>
<tr>
<td>5.08.2018</td>
<td>Проверка на орфографию.</td>
<td><strong>done</strong></td>
</tr>
<tr>
<td>6.08.2018</td>
<td>Поддержка подготовленных запросов.</td>
<td><strong>done</strong></td>
</tr>
<tr>
<td><center>—</center></td>
<td>Реализация созданий навыков при помощи JSON-блоков.</td>
<td><strong>in progges</strong></td>
</tr>
<tr>
<td><center>—</center></td>
<td>Отправка сообщений с фотографиями.</td>
<td><strong>in plan</strong></td>
</tr>
<tr>
<td><center>—</center></td>
<td>Оплата при помощи компании Unitpay.</td>
<td><strong>in plan</strong></td>
</tr>
<tr>
<td><center>—</center></td>
<td>Теперь можно делать вариации вопросов и ответов</td>
<td><strong>in plan</strong></td>
</tr>
</tbody>
</table><h2 id="установка">Установка</h2>
<pre><code>composer require danil005/php-yandex-alisa
</code></pre>
<h2 id="описание-констант">Описание констант</h2>
<h3 id="skill_name">SKILL_NAME</h3>
<p>Название навыка.</p>
<hr>
<h3 id="version">VERSION</h3>
<p>Версия Алиса API. По умолчанию: 1.0</p>
<h2 id="описание-переменных">Описание переменных</h2>
<h3 id="private-startmessage--">private $startMessage = “”</h3>
<p>Сообщение, которое будет отображаться при старте навыка.</p>
<hr>
<h3 id="private-startmessagetts--">private $startMessageTTS = “”</h3>
<p>Сообщение, которое будет озвучено синтезом речи Yandex.</p>
<hr>
<h3 id="private-startbutton--">private $startButton = []</h3>
<p>Кнопки, которые будут отображены при запуске навыка</p>
<hr>
<h3 id="private-version--selfversion">private $version = self::VERSION</h3>
<p>Наследует константу VERSION.</p>
<hr>
<h3 id="private-anymessage---простите-я-вас-не-понимаю.">private $anyMessage  = “Простите, я вас не понимаю.”</h3>
<p>Сообщение, которое будет отправлено пользователю в случае, если команда не будет найдена.</p>
<hr>
<h3 id="private-casesensitive--true">private $caseSensitive = true</h3>
<p>Чувствительность к регистру сообщений.</p>
<hr>
<h3 id="private-speller--false">private $speller = false</h3>
<p>Проверка на орфографию.</p>
<hr>
<h3 id="public-vars--">public $vars = []</h3>
<p>Переменная для обработки Prepare-функции.</p>
<hr>
<h3 id="private-request--">private $request = []</h3>
<p>Переменная, которая получает ответ от Алисы.</p>
<hr>
<h3 id="public-response--stdobject">public $response = stdObject</h3>
<p>Переменная для формирования ответа на полученный запрос от Алисы.</p>
<h2 id="описание-методов">Описание методов</h2>
<h3 id="public-setcasesensitivebool-sensitive--true-this">public setCaseSensitive(bool $sensitive = true): $this</h3>
<p>Метод, который меняет чувствительность к регистру.<br>
<code>TRUE</code> - включить чувствительность.<br>
<code>FALSE</code> - выключить чувствительность.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>sensitive</td>
<td>bool</td>
<td>Чувствительно к регистру.</td>
<td>true</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-setanystring-message-this">public setAny(String $message): $this</h3>
<p>Метод, который устанавливает сообщение по умолчанию, если чат-бот не смог понять, что от него хотят.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>message</td>
<td>String</td>
<td>Текст сообщения.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-setversionstring-version--selfversion-this">public setVersion(String $version = self::VERSION): $this</h3>
<p>Метод, который устанавливает версию Алиса API.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>version</td>
<td>String</td>
<td>Версия Алиса API.</td>
<td>Данные с константы VERSION</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-setspellercorrectbool-speller--false-this">public setSpellerCorrect(bool $speller = false): $this</h3>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>speller</td>
<td>bool</td>
<td>Установить проверку на орфографию и ее исправления в случае нахождении ошибки.</td>
<td>false</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-setendmessage-this">public setEndMessage(): $this</h3>
<p>Метод, который завершает сессию и закрывает навык.</p>
<hr>
<h3 id="public-addstartmessagestring-message-this">public addStartMessage(String $message): $this</h3>
<p>Метод, который устанавливает сообщение при старте навыка.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>message</td>
<td>String</td>
<td>Текст сообщения.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-addstartttsstring-message-this">public addStartTTS(String $message): $this</h3>
<p>Метод, который устанавливает сообщение при старте навыка для синтеза речи.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>message</td>
<td>String</td>
<td>Текст сообщения.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-addstartbuttonstring-title-bool-hide--false-array-payload---string-url--null-this">public addStartButton(String $title, bool $hide = false, Array $payload = [], String $url = null): $this</h3>
<p>Метод, который устанавливает кнопки при старте навыка.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>title</td>
<td>String</td>
<td>Название кнопки.</td>
<td>Обязательно</td>
</tr>
<tr>
<td>hide</td>
<td>bool</td>
<td>Спрятать кнопки после нажатия.</td>
<td>false</td>
</tr>
<tr>
<td>payload</td>
<td>Array</td>
<td>Отправить дополнительные данные для обработки.</td>
<td>[]</td>
</tr>
<tr>
<td>url</td>
<td>String</td>
<td>URL-ссылка</td>
<td>null</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-addbuttonstring-title-bool-hide--false-array-payload---string-url--null-this">public addButton(String $title, bool $hide = false, Array $payload = [], String $url = null): $this</h3>
<p>Метод, который устанавливает кнопки.</p>
<p><strong>ВНИМАНИЕ!</strong><br>
<strong>Обязательно перед этим методом использовать sendMessage();</strong></p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>title</td>
<td>String</td>
<td>Название кнопки.</td>
<td>Обязательно</td>
</tr>
<tr>
<td>hide</td>
<td>bool</td>
<td>Спрятать кнопки после нажатия.</td>
<td>false</td>
</tr>
<tr>
<td>payload</td>
<td>Array</td>
<td>Отправить дополнительные данные для обработки.</td>
<td>[]</td>
</tr>
<tr>
<td>url</td>
<td>String</td>
<td>URL-ссылка</td>
<td>null</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-sendmessagestring-message-string-tts---bool-speller--false--this">public sendMessage(String $message, String $tts = “”, bool $speller = false ): $this</h3>
<p>Отправить сообщение пользователю.<br>
Использовать speller в этом методе не так важно, ведь вы сами можете вводить корректный текст, однако если вы не уверены в написании или боитесь, что где-то сделали опечатку, то можете использовать этот аргумент и поставить его на <code>TRUE</code>.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>message</td>
<td>String</td>
<td>Текст сообщения.</td>
<td>Обязательно</td>
</tr>
<tr>
<td>tts</td>
<td>String</td>
<td>Синтез речи, ударения, паузы.</td>
<td>“”</td>
</tr>
<tr>
<td>speller</td>
<td>bool</td>
<td>Проверка на орфографию и исправление, если будет найдена ошибка.</td>
<td>false</td>
</tr>
</tbody>
</table><hr>
<h3 id="protected-optionsquestionsarray-list-string-command-bool">protected optionsQuestions(Array $list, String $command): bool</h3>
<p>Вариация реагирования на фразы для выполнения определенного дейсвтия указанного в<br>
<a href="#public-cmdstring-command">cmd()</a>.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>list</td>
<td>Array</td>
<td>Лист ключевых слов для вызова действия.</td>
<td>Обязательно</td>
</tr>
<tr>
<td>command</td>
<td>String</td>
<td>Команда пришедшая от пользователя на сервер.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="protected-optionsanswersarray-list-mixed">protected optionsAnswers(Array $list): mixed</h3>
<p>Отправить вариационный ответ пользователю. Например, если вы не хотите отправлять пользователю одно и тоже сообщение, то можно использовать этот метод и расширить диапазон речи.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>list</td>
<td>array</td>
<td>Лист фраз, которые будет выдавать Алиса-навык.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="protected-optionscallbackarray-list-array-callback-this">protected optionsCallback(Array $list, Array $callback): $this</h3>
<p>Метод, который позволяет делать логическую операцию ИЛИ. В этом случае указывается набор<br>
фраз, которые возможны при возврате payload (Callback). В случае если это слово будет найдено, то выдает <code>TRUE</code>. Также можно отправлять несколько Payload для одного действия и тем самым через эту функцию написать их оба.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>list</td>
<td>Array</td>
<td>Лист ключевых слов.</td>
<td>Обязательно</td>
</tr>
<tr>
<td>callback</td>
<td>String</td>
<td>Обязательная переменная, которая передается в функцию для обработки.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-preparestring-getmessage-string-command-bool">public prepare(String $getMessage, String $command): bool</h3>
<p>Метод, который позволяет делать подготовленные запросы и в последствии выводить их. Возвращает <code>true</code> или <code>false</code>, а также записывает результат функции в переменную <code>$this-&gt;vars</code>.</p>
<p>Пример:</p>
<pre><code>if( $this-&gt;prepare("Купить {what} за {price}", $command) ) {  
  $this-&gt;sendMessage("Вы уверены, что хотите купить
   {$this-&gt;vars['whats']} за {$this-&gt;vars['price']}₽?");  
  return true;  
}
</code></pre>
<p>Как вы можете заметить, ключи переменной vars отображают подготовленные ключи из аргумента <code>String $getMessage</code>.</p>

<table>
<thead>
<tr>
<th>Аргумент</th>
<th>Тип</th>
<th>Описание</th>
<th>По умолчанию</th>
</tr>
</thead>
<tbody>
<tr>
<td>getMessage</td>
<td>String</td>
<td>Сообщение, которое должен принять навык для обработки данных.</td>
<td>Обязательно</td>
</tr>
<tr>
<td>command</td>
<td>String</td>
<td>Сообщение которое придет от пользователя.</td>
<td>Обязательно</td>
</tr>
</tbody>
</table><hr>
<h3 id="public-listen-boolnull">public listen(): bool|null</h3>
<p>Начать прослушивать Webhook.<br>
<strong>Данный метод обязательно указывать в конце цепочки.</strong></p>
<hr>
<h3 id="public-cmdstring-command">public cmd(String $command)</h3>
<p>Метод в котором необходимо обрабатывать все данные.<br>
<strong>Обязательно указывать</strong> <code>return true;</code> <strong>после каждого условия.</strong></p>
<pre><code>if( $command == "привет" ) {  
  $this-&gt;sendMessage("Приветик")-&gt;addButton("А что ты умеешь?");  
  return true;  
}  
//Или 
if( $this-&gt;optionsQuestions(["привет", "здравствуйте"]) ) {  
  $this
  -&gt;sendMessage($this-&gt;optionsAnswers(["Добрый день!", "Я рада вас видеть!"]))
  -&gt;addButton("А что ты умеешь?");  
  return true;  
}
//Или 
if( $this-&gt;prepare("забронируй мне {what} на {time} в {when}", $command) ) {  
  $this-&gt;sendMessage
  ("Мы забронировали 
	  {$this-&gt;vars['what']}
   на {$this-&gt;vars['time']}
    в {$this-&gt;vars['when']}"
  );  
  return true;  
}

return false;
</code></pre>
<hr>
<h3 id="public-payloadarray-callback">public payload(Array $callback)</h3>
<p>Метод в котором необходимо обрабатывать все данные пришедших с payload…<br>
<strong>Обязательно указывать</strong> <code>return true;</code> <strong>после каждого условия.</strong></p>
<pre><code>if( array_key_exists('help', $callback) ) {  
  $this-&gt;sendMessage('Много чего! А ты?');  
  return true;  
}  
//Или
if( $this-&gt;optionsCallback(["help", "helpme"], $callback) ) {  
  $this-&gt;sendMessage('Много чего! А ты?');  
  return true;  
}  
return false;
</code></pre>
<hr>
<h3 id="index.php">index.php</h3>
<p>Файл для запуска чат бота.<br>
Вы также можете изменить название файла, однако необходимо указывать то, что приведено к примеру ниже:</p>
<pre><code>$main = new \yandex\alisa\Alisa();  
$main-&gt;addStartMessage("Добро пожаловать")-&gt;setCaseSensitive(false)-&gt;listen();
</code></pre>
<h3 id="локальный-webhook">Локальный Webhook:</h3>
<p>Чтобы запустить локальный webhook необходимо пройти на <a href="https://ngrok.com/">ngrko</a> и создать аккаунт.<br>
После скачать программу и кинуть ее в удобно для вас место.<br>
Запустите командную строку и пропишете:<br>
ngrok http <code>port</code><br>
Если это локальный сайт, то можете написать ngrok http <code>example.ru:port</code><br>
В случае, если вы используете <a href="https://ospanel.io/">OpenServer</a> , то необходимо еще указать алису в настройках:<br>
<img src="http://dl4.joxi.net/drive/2018/08/02/0024/0050/1622066/66/f83b666c74.png" alt="enter image description here"><br>
При успешном запуске, просто введите этот адрес в Webhook URL:<br>
<img src="http://dl4.joxi.net/drive/2018/08/02/0024/0050/1622066/66/b5e67d7a60.png" alt="enter image description here"></p>
<hr>
<p>Version: 1.2<br>
Danil Sidorenko © MIT 2018</p>


# PHP-YANDEX-ALISA
Библиотека для работы с Алисой.
___

## Содержание
1. [TODO](#todo)
2. [Установка](#%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0)
3. [Описание констант](#%D0%9E%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BA%D0%BE%D0%BD%D1%81%D1%82%D0%B0%D0%BD%D1%82)
4. [Описание переменных](#%D0%9E%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BF%D0%B5%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%BD%D1%8B%D1%85)
5. [Описание методов](#%D0%9E%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BC%D0%B5%D1%82%D0%BE%D0%B4%D0%BE%D0%B2)
6. [index.php](#indexphp)
7. [Локальный Webhook.](#%D0%9B%D0%BE%D0%BA%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9-webhook)

___
## TODO
|Дата|Описание релиза|Состояние 
|--|--|--|
| 5.08.2018 |Теперь можно делать вариации вопросов и ответов.  |**done**
| 5.08.2018 |Выполнять payload-функции (callback).  |**done**
| 5.08.2018 |Проверка на орфографию.  |**done**
| 6.08.2018 |Поддержка подготовленных запросов.  |**done**
|<center>---</center>|Реализация созданий навыков при помощи JSON-блоков.   |**in progges**
|<center>---</center>|Отправка сообщений с фотографиями.  |**in plan**
|<center>---</center>|Оплата при помощи компании Unitpay. |**in plan**
|<center>---</center>|Теперь можно делать вариации вопросов и ответов  |**in plan**

## Установка
  ``` 
composer require danil005/php-yandex-alisa
 ```
## Описание констант
### SKILL_NAME 
Название навыка.
___
### VERSION
Версия Алиса API. По умолчанию: 1.0
## Описание переменных
### private $startMessage = ""
Сообщение, которое будет отображаться при старте навыка.
___
### private $startMessageTTS = ""
Сообщение, которое будет озвучено синтезом речи Yandex.
___
### private $startButton = []
Кнопки, которые будут отображены при запуске навыка
___
### private $version = self::VERSION
Наследует константу VERSION.
___
### private $anyMessage  = "Простите, я вас не понимаю." 
Сообщение, которое будет отправлено пользователю в случае, если команда не будет найдена.
___
### private $caseSensitive = true
Чувствительность к регистру сообщений.
___
### private $speller = false
Проверка на орфографию.
___
### public $vars = []
Переменная для обработки Prepare-функции.
___
### private $request = []
Переменная, которая получает ответ от Алисы.
___
### public $response = stdObject
Переменная для формирования ответа на полученный запрос от Алисы.
## Описание методов
### public setCaseSensitive(bool $sensitive = true): $this
Метод, который меняет чувствительность к регистру.
`TRUE` - включить чувствительность.
`FALSE` - выключить чувствительность.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|sensitive|bool|Чувствительно к регистру.  |true 
___
### public setAny(String $message): $this
Метод, который устанавливает сообщение по умолчанию, если чат-бот не смог понять, что от него хотят.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|message|String|Текст сообщения.  |Обязательно 
___
### public setVersion(String $version = self::VERSION): $this
Метод, который устанавливает версию Алиса API. 
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|version|String|Версия Алиса API.  |Данные с константы VERSION 
___
### public setSpellerCorrect(bool $speller = false): $this
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|speller|bool|Установить проверку на орфографию и ее исправления в случае нахождении ошибки.  |false
___
### public setEndMessage(): $this
Метод, который завершает сессию и закрывает навык.
___

### public addStartMessage(String $message): $this
Метод, который устанавливает сообщение при старте навыка.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|message|String|Текст сообщения.  |Обязательно 
___
### public addStartTTS(String $message): $this
Метод, который устанавливает сообщение при старте навыка для синтеза речи.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|message|String|Текст сообщения.  |Обязательно 
___
### public addStartButton(String $title, bool $hide = false, Array $payload = [], String $url = null): $this
Метод, который устанавливает кнопки при старте навыка.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|title  |String|Название кнопки.  |Обязательно 
|hide|bool|Спрятать кнопки после нажатия.|false
|payload|Array|Отправить дополнительные данные для обработки.|[]
|url|String|URL-ссылка|null
___
### public addButton(String $title, bool $hide = false, Array $payload = [], String $url = null): $this
Метод, который устанавливает кнопки.


**ВНИМАНИЕ!**
**Обязательно перед этим методом использовать sendMessage();**
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|title  |String|Название кнопки.  |Обязательно 
|hide|bool|Спрятать кнопки после нажатия.|false
|payload|Array|Отправить дополнительные данные для обработки.|[]
|url|String|URL-ссылка|null
___
### public sendMessage(String $message, String $tts = "", bool $speller = false ): $this
Отправить сообщение пользователю. 
Использовать speller в этом методе не так важно, ведь вы сами можете вводить корректный текст, однако если вы не уверены в написании или боитесь, что где-то сделали опечатку, то можете использовать этот аргумент и поставить его на `TRUE`.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|message|String|Текст сообщения.  |Обязательно 
|tts|String|Синтез речи, ударения, паузы.|""
|speller|bool|Проверка на орфографию и исправление, если будет найдена ошибка.|false
___
### protected optionsQuestions(Array $list, String $command): bool
Вариация реагирования на фразы для выполнения определенного дейсвтия указанного в 
[cmd()](#public-cmdstring-command).
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|list|Array|Лист ключевых слов для вызова действия.  |Обязательно 
|command|String|Команда пришедшая от пользователя на сервер.|Обязательно
___
### protected optionsAnswers(Array $list): mixed
Отправить вариационный ответ пользователю. Например, если вы не хотите отправлять пользователю одно и тоже сообщение, то можно использовать этот метод и расширить диапазон речи.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|list|array|Лист фраз, которые будет выдавать Алиса-навык.  |Обязательно 
___
### protected optionsCallback(Array $list, Array $callback): $this
Метод, который позволяет делать логическую операцию ИЛИ. В этом случае указывается набор
фраз, которые возможны при возврате payload (Callback). В случае если это слово будет найдено, то выдает `TRUE`. Также можно отправлять несколько Payload для одного действия и тем самым через эту функцию написать их оба.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|list|Array|Лист ключевых слов.  |Обязательно 
|callback|String|Обязательная переменная, которая передается в функцию для обработки.|Обязательно
___
### public prepare(String $getMessage, String $command): bool
Метод, который позволяет делать подготовленные запросы и в последствии выводить их. Возвращает `true` или `false`, а также записывает результат функции в переменную `$this->vars`. 

Пример:

    if( $this->prepare("Купить {what} за {price}", $command) ) {  
	  $this->sendMessage("Вы уверены, что хотите купить
	   {$this->vars['whats']} за {$this->vars['price']}₽?");  
	  return true;  
	}

Как вы можете заметить, ключи переменной vars отображают подготовленные ключи из аргумента `String $getMessage`.
|Аргумент|Тип| Описание  |По умолчанию|
|--|--|--|--|
|getMessage|String|Сообщение, которое должен принять навык для обработки данных.  |Обязательно 
|command|String|Сообщение которое придет от пользователя.|Обязательно
___
### public listen(): bool|null
Начать прослушивать Webhook. 
**Данный метод обязательно указывать в конце цепочки.**
___
### public cmd(String $command)
Метод в котором необходимо обрабатывать все данные.
**Обязательно указывать** `return true;` **после каждого условия.**

    if( $command == "привет" ) {  
	  $this->sendMessage("Приветик")->addButton("А что ты умеешь?");  
	  return true;  
	}  
	//Или 
	if( $this->optionsQuestions(["привет", "здравствуйте"]) ) {  
	  $this
	  ->sendMessage($this->optionsAnswers(["Добрый день!", "Я рада вас видеть!"]))
	  ->addButton("А что ты умеешь?");  
	  return true;  
	}
	//Или 
	if( $this->prepare("забронируй мне {what} на {time} в {when}", $command) ) {  
	  $this->sendMessage
	  ("Мы забронировали 
		  {$this->vars['what']}
	   на {$this->vars['time']}
	    в {$this->vars['when']}"
	  );  
	  return true;  
	}
  
	return false;
___
### public payload(Array $callback)
Метод в котором необходимо обрабатывать все данные пришедших с payload..
**Обязательно указывать** `return true;` **после каждого условия.**

    if( array_key_exists('help', $callback) ) {  
	  $this->sendMessage('Много чего! А ты?');  
	  return true;  
	}  
	//Или
	if( $this->optionsCallback(["help", "helpme"], $callback) ) {  
	  $this->sendMessage('Много чего! А ты?');  
	  return true;  
	}  
	return false;
___
### index.php
Файл для запуска чат бота.
Вы также можете изменить название файла, однако необходимо указывать то, что приведено к примеру ниже:

    $main = new \yandex\alisa\Alisa();  
	$main->addStartMessage("Добро пожаловать")->setCaseSensitive(false)->listen();

### Локальный Webhook: 
Чтобы запустить локальный webhook необходимо пройти на [ngrko](https://ngrok.com/) и создать аккаунт.
После скачать программу и кинуть ее в удобно для вас место.
Запустите командную строку и пропишете: 
ngrok http `port`
Если это локальный сайт, то можете написать ngrok http `example.ru:port`
В случае, если вы используете [OpenServer](https://ospanel.io/) , то необходимо еще указать алису в настройках:
![enter image description here](http://dl4.joxi.net/drive/2018/08/02/0024/0050/1622066/66/f83b666c74.png)
При успешном запуске, просто введите этот адрес в Webhook URL:
![enter image description here](http://dl4.joxi.net/drive/2018/08/02/0024/0050/1622066/66/b5e67d7a60.png)

___
Version: 1.2
Danil Sidorenko © MIT 2018
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
<ul>
<li>Теперь можно делать вариации вопросов и ответов. <strong>done</strong></li>
<li>Выполнять payload-функции (callback). <strong>done</strong></li>
<li>Реализация созданий навыков при помощи JSON-блоков.</li>
<li>Отправка сообщений с фотографиями.</li>
<li>Оплата при помощи компании Unitpay.</li>
</ul>
<h2 id="установка">Установка</h2>
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
<h3 id="public-sendmessagestring-message-string-tts---this">public sendMessage(String $message, String $tts = “”): $this</h3>
<p>Отправить сообщение пользователю.</p>

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
<p>Version: 1.0<br>
Danil Sidorenko © MIT 2018</p>


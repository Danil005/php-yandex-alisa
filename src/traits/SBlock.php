<?php

namespace yandex\alisa\traits;

trait SBlock {

	/**
	 * Получить отправленную команду для JSON-блоков.
	 * @var string
	 */
	private $__command = "";

	/**
	 * Ошибки JSON-блоков.
	 * @var array
	 */
	private $errorMessages = [
		1=>"question or prepare method not found",
		2=>"sent method not found",
		3=>"method for button not found",
		4=>"this function ({function}) wasn't found",
		5=>"var \"{input}\" not found from varsToPayload"
	];

	/**
	 * Построение ошибки JSON-блоков.
	 * @param int    $error
	 * @param array  $input
	 *
	 * @return string
	 */
	private function errorMessage(int $error, array $input = []) {
		if( $input != "" ) {
			foreach ($input as $placeholder=>$value) {
				if( strstr($this->errorMessages[$error], $placeholder) ) {
					$this->errorMessages[$error] = str_replace('{' .$placeholder . '}', $value, $this->errorMessages[$error]);
				}
			}
		}
		return "[ERROR#".$error."] Fatal error: ".$this->errorMessages[$error].".";
	}

	/**
	 * Выполнить блоковую стркутуру на JSON-файлах.
	 * @param String $command
	 *
	 * @return bool
	 */
	public function executeBlockSystem(String $command) {
		$command = mb_strtolower($command);
		$this->__command = $command;
		$action = $this->objectToArray($this->read('actions.json'));


		foreach ($action as &$value) {
			if( array_key_exists('question', $value) || array_key_exists('prepare', $value)  ) {
				if( array_key_exists('send', $value) ) {
					$foundPrepare = $this->prepare($value['prepare'], $command);
					$foundCommand = false;
					$prepareCommand = false;


					if( array_key_exists('prepare', $value)
					    && !empty($value['prepare'])
					    && $foundPrepare ) {
						$prepareCommand = true;
					}

					if( is_array($value['question']) ) {
						foreach ($value['question'] as $question) {
							if( $question == $command ) {
								$foundCommand = true;
							}
						}
					} else {
						if( $value['question'] == $command ) {
							$foundCommand = true;
						}
					}
					if ( $foundCommand ||
					     (
						     array_key_exists('prepare', $value)
						     && !empty($value['prepare'])
						     && $foundPrepare
					     )
					) {
						if( array_key_exists('message', $value['send']) ) {
							if( is_array($value['send']['message']) ) {
								if( !array_key_exists(0, $value['send']['message']) ) {
									if( array_key_exists('question', $value['send']['message']) && $foundCommand) {
										if( is_array($value['send']['message']['question']) ) {
											$rand = $this->optionsAnswers($value['send']['message']['question'], 1);

											$tts = ( is_array($value['send']['tts']['question']) ) ? $value['send']['tts']['question'][$rand] : $value['send']['tts']['question'];

											$this->sendMessage($value['send']['message']['question'][$rand], $tts);
										} else {
											$this->sendMessage($value['send']['message']['question'], $value['send']['tts']['question']);
										}
									}
									if( array_key_exists('prepare', $value['send']['message']) && $prepareCommand) {
										if( is_array($value['send']['message']['prepare']) ) {
											$rand = $this->optionsAnswers( $value['send']['message']['prepare'], 1 );

											$tts = ( is_array($value['send']['tts']['prepare']) ) ? $value['send']['tts']['prepare'][$rand] : $value['send']['tts']['prepare'];

											$this->sendMessage(
												$this->printVars( $value['send']['message']['prepare'][ $rand ] ),
												$this->printVars( $tts )
											);
										} else {
											$this->sendMessage(
												$this->printVars( $value['send']['message']['prepare']),
												$this->printVars( $value['send']['tts']['prepare'])
											);
										}
									}
								} else {
									$rand = $this->optionsAnswers($value['send']['message'], 1);
									$this->sendMessage($value['send']['message'][$rand], $value['send']['tts'][$rand]);
								}
							} else {
								$this->sendMessage($value['send']['message'], $value['send']['tts']);
							}
						}
						if( array_key_exists('buttons', $value['send']) ) {
							if( array_key_exists('question', $value['send']['buttons']) || array_key_exists('prepare', $value['send']['buttons']) ) {
								if( $foundCommand ) {
									if( is_array($value['send']['buttons']['question'][0]) ) {
										foreach ($value['send']['buttons']['question'] as $argument => $val) {
											if( array_key_exists('varsToPayload', $value['send']) && $value['send']['varsToPayload'] == true ) {
												foreach ($val['payload'] as $nPayload=>$vPayload) {
													$val['payload'][$nPayload]['vars'] =
														array_merge($val['payload'][$nPayload]['vars'], $this->getVar($value));
												}
											}
											$this->addButton($val['title'],
												$val['hide'],
												$val['payload'],
												$val['url']);
										}
									} else {
										$buArrayQuestion = $value['send']['buttons']['question'];
										foreach ($buArrayQuestion['payload'] as $nPayload=>$vPayload) {
											$buArrayQuestion['payload'][$nPayload]['vars'] =
												array_merge($buArrayQuestion['payload'][$nPayload]['vars'], $this->getVar($value));
										}
										$this->addButton(
											$buArrayQuestion['title'],
											$buArrayQuestion['hide'],
											$buArrayQuestion['payload'],
											$buArrayQuestion['url']
										);
									}
								} elseif( $prepareCommand ) {
									if( is_array($value['send']['buttons']['prepare'][0]) ) {
										foreach ($value['send']['buttons']['prepare'] as $argument => $val) {
											foreach ($val['payload'] as $nPayload=>$vPayload) {
												$val['payload'][$nPayload]['vars'] =
													array_merge($val['payload'][$nPayload]['vars'], $this->getVar($value));
											}
											$this->addButton($val['title'],
												$val['hide'],
												$val['payload'],
												$val['url']);

										}
									} else {
										$buArrayPrepare = $value['send']['buttons']['prepare'];

										foreach ($buArrayPrepare['payload'] as $nPayload=>$vPayload) {
											$buArrayPrepare['payload'][$nPayload]['vars'] = array_merge($buArrayPrepare['payload'][$nPayload]['vars'], $this->getVar($value));
										}
										$this->addButton(
											$buArrayPrepare['title'],
											$buArrayPrepare['hide'],
											$buArrayPrepare['payload'],
											$buArrayPrepare['url']
										);
									}
								} else {
									die($this->errorMessage(3));
								}
							} else {
								if( is_array($value['send']['buttons'][0]) ) {
									foreach ($value['send']['buttons'] as $kb=>$val) {
										foreach ($val['payload'] as $nPayload=>$vPayload) {
											$val['payload'][$nPayload]['vars'] =
												array_merge($val['payload'][$nPayload]['vars'], $this->getVar($value));
										}
										$this->addButton(
											$val['title'],
											$val['hide'],
											$val['payload'],
											$val['url']
										);
									}
								} else {
									foreach ($value['send']['buttons']['payload'] as $nPayload=>$vPayload) {
										$value['send']['buttons']['payload'][$nPayload]['vars'] =
											array_merge($value['send']['buttons']['payload'][$nPayload]['vars'] , $this->getVar($value));
									}
									$this->addButton(
										$value['send']['buttons']['title'],
										$value['send']['buttons']['hide'],
										$value['send']['buttons']['payload'],
										$value['send']['buttons']['url']
									);
								}
							}
						}
					} else {
						return $this->sendMessage(
							$this->anyMessage
						);
					}
					return true;
				} else {
					die($this->errorMessage(2));
				}
			} else {
				die($this->errorMessage(1));
			}
		}

		return false;
	}

	/**
	 * Получить переменные, чтобы отправить их в Callback.
	 * @param array $value
	 *
	 * @return array
	 */
	public function getVar(Array $value) {
		$params = []; $s = [];

			if( !is_array($value['prepare']) ) {
				$words = explode( " ", $value['prepare'] );
				foreach ( $words as $key => $text ) {
					if ( strstr($text, '{') && strstr($text, '}') ) {
						$var = substr( strstr($text, '{'), 1, strpos($text, '}') - 1 );
						if ( strstr($value['prepare'], "{" . $var . "}" ) ) {
							$s[] = $var;
						}
					}
				}
			} else {
				foreach ($value['prepare'] as $prepare) {
					$words = explode( " ", $prepare );
					foreach ( $words as $key => $text ) {
						if ( strstr($text, '{') && strstr($text, '}') ) {
							$var = substr( strstr($text, '{'), 1, strpos($text, '}') - 1 );
							if ( strstr($prepare, "{" . $var . "}" )
							     && $this->__command == str_replace("{".$var."}", $this->vars[$var], $prepare)) {
								$s[] = $var;
							}
						}
					}
				}
			}
		$params[$s[0]] = $this->vars[$s[0]];

		return $params;
	}

	public function executePayload(Array $callback) {
		$payload = $this->objectToArray( $this->read( 'payload.json' ) );
		$cPayload = count($payload);
		$i=0;
		foreach ($callback as $key=>$value) {
			$message = ""; $tts = ""; $button = [];
			foreach ( $payload as $function => $execute ) {
				if ( in_array($function, $value) ) {
					if( array_key_exists('sendMessage', $execute) )  {
						foreach ($execute as &$func) {
							$rand = 0;
							foreach ($value['vars'] as $param=>$val) {

								if( is_array($func['message']) ) {
									$rand = $this->optionsAnswers($func['message'], 1);
									$func['message'] = $func['message'][$rand];
								}

								$words = explode(" ", $func['message']);
								foreach ($words as $key => $text) {
									if (strstr($text, '$') && strstr($text, '$')) {
										$var = substr(strstr($text, '$'), 1,strpos($text, '$') - 1);

										if( strstr($text, '^') ) {
											$val = $this->spellingCheck($val);
										}
										$var = str_replace('^', '', $var);
										$func['message'] = str_replace('^', '', $func['message']);

										if( strstr($text, "|") ) {
											if( explode('|', $var)[0] == $param || explode('|', $var)[1] == $param ) {
												$message = $func['message'];
												$message = str_replace("$".$var."$", $val, $message);
											}
										} else {
											if( $var == $param ) {
												$message = $func['message'];
												$message = str_replace("$".$var."$", $val, $message);
											}
										}
									}
								}
								if( $message == "" ) {
									$message = $func['message'];
								}

								if( is_array($func['tts']) ) {
									$func['tts'] = $func['tts'][$rand];
								}
								$wordsTts = explode(" ", $func['tts']);
								foreach ($wordsTts as $key => $text) {
									if (strstr($text, '$') && strstr($text, '$')) {
										$var = substr(strstr($text, '$'), 1,strpos($text, '$') - 1);
										if( strstr($text, "|") ) {
											if( explode('|', $var)[0] == $param || explode('|', $var)[1] == $param ) {
												$tts = $func['tts'];
												$tts = str_replace("$".$var."$", $val, $tts);
											}
										} else {
											if( $var == $param ) {
												$tts = $func['tts'];
												$tts = str_replace("$".$var."$", $val, $tts);
											}
										}
									}
								}
								if( $tts == "" ) {
									$tts = $func['tts'];
								}
							}
						}
					}
					if( array_key_exists('sendButtons', $execute) )  {
						if( is_array($execute['sendButtons'][0]) ) {
							foreach ($execute['sendButtons'] as $kb=>$v) {
								foreach ($execute['sendButtons'][$kb]['payload'] as $nPayload => $vPayload) {
									$execute['sendButtons'][$kb]['payload'][$nPayload]['vars'] = $value['vars'];
								}
							}
							foreach ($execute['sendButtons'] as $kb=>$val) {
								$button  = $val;
							}
						} else {
							foreach ($execute['sendButtons']['payload'] as $nPayload => $vPayload) {
								$execute['sendButtons']['payload'][$nPayload]['vars'] = $value['vars'];
							}
							$button = $execute['sendButtons'];
						}
					}
					$this->sendPayload($message, $tts, $button);
					return true;
				} else {
					if( $i++ < $cPayload ) {
						continue;
					}
					die( $this->errorMessage(4, ['function'=>$function]));
				}
			}
		}
		return false;
	}
}
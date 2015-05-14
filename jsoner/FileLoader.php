<?php 
class FileLoader
{

	/**
	 * file path.
	 * @var string
	 */
	protected $file;

	/**
	 * content of the file
	 * @var array
	 */
	protected $data = [];
	
	/**
	 * set filename, and check for errors
	 * load if everything is well.
	 * @param string $filename
	 */
	public function __construct($file)
	{
		$this->file = $file;
		$this->fileExists();
		$this->data = $this->load();
		$this->errorCheck();
	}

	/**
	 * Load content of the file.
	 * @return array
	 */
	private function load()
	{
		return json_decode( file_get_contents($this->file), true);
	}

	/**
	 * return file content as array
	 * @return array
	 */
	public function getContent()
	{
		return $this->data;
	}

	/**
	 * check if the file exists!
	 */
	public function fileExists()
	{
		if ( ! file_exists( $this->file )) 
			throw new Exception("File not found ".$this->file);
		return;
	}

	/**
	 * Check if there is an error in opening the json!
	 */
	private function errorCheck()
	{
		if ( 0 < $errorCode = json_last_error() ) {
			throw new Exception(
				sprintf('Error Loading Json %s.', $this->getErrorMessage($errorCode))
			);
		}
	}

	/**
	 * Get the error message !
	 * @param  $code
	 * @return string error message
	 */
	private function getErrorMessage($code)
	{
		switch( $code ) {
			case JSON_ERROR_DEPTH:
				return 'Maximum stack depth exceeded';
			case JSON_ERROR_STATE_MISMATCH:
				return 'Underflow or the modes mismatch';
			case JSON_ERROR_CTRL_CHAR:
				return 'Unexpected control character found';
			case JSON_ERROR_SYNTAX:
				return 'Syntax error, malformed JSON';
			case JSON_ERROR_UTF8:
				return 'Malformed UTF-8 characters, possibly incorrectly encoded';
			default:
				return 'Unknown error';
		}
	}

	/**
	 * Save array to the file.
	 * @param  string $file file path
	 * @param  array $data content to be saved
	 */
	public function save($file, $data)
	{
		if ( ! is_null( $file ) ) $this->file = $file;
		$this->fileExists();
		$this->parseContent($data);
	}

	/**
	 * parse content from array to Json
	 * @param  array $data
	 */
	private function parseContent($data)
	{
		$json = json_encode($data);
        $this->errorCheck();
        $this->setContent($json);
	}

	/**
	 * Put the content as json to File
	 * @param json $data
	 */
	private function setContent($data)
	{
		$result = file_put_contents($this->file, $data);
		if( ! $result ) throw new Exception("Failed while saving file! ");
		return true;
	}
	
}
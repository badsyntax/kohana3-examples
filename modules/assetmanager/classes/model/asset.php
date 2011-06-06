<?php defined('SYSPATH') or die('No direct script access.');

class Model_Asset extends Model_Base_Asset {
	
	public function admin_upload(& $file = array(), $field_name = 'asset')
	{
		$file_data = $file;
		$filename = strtolower($file[$field_name]['name']);

		// Get the validation rules
		$rules = $this->_rules['upload'];
		
		// Add allowed upload types to validation
		$rules['Upload::type'] = array(explode(',', Kohana::config('asset.allowed_upload_type')));

		// Add file extension to file array (which we'll be validating against the available mimetypes)
		$file['extension'] = strtolower(trim(strrchr($filename, '.'), '.'));

		// Add validation rules
		$file = Validate::factory($file)
			->rules($field_name, $rules);
						
		// Add validation callbacks			
		foreach($this->_callbacks['upload'] as $type => $callbacks)
		{
			foreach($callbacks as $callback)
			{
				$file->callback('extension', array($this, $callback));
			}
		}

		// Validate the data
		if (!$file->check())
		{	
			return $this;
		}

		// Try move the asset to the specified upload path
		try
		{
			$filepath = Upload::save($file_data[$field_name], $filename, DOCROOT.Kohana::config('admin/asset.upload_path'));
		}
		catch(Exception $e)
		{
			throw new Exception($e);
		}

		$description = preg_replace('/\.\w+$/', '', $filename);		// remove extension
		$description = preg_replace('/[_-]/', ' ', $description);	// replace special chars

		// Save the file data
		$data = array(
			'user_id' => Auth::instance()->get_user()->id,
			'mimetype_id' => $file['mimetype_id'], // Set in validation callback
			'filename' => $filename,
			'friendly_filename' => $filename,
			'description' => $description,
			'filesize' => (int) $file_data[$field_name]['size']
		);		
		$this->values($data);
		$this->save();

		// Create a new filename with id prefixed
		$new_filename = str_replace($this->filename, $this->id.'_'.$this->filename, $filepath);
		$this->filename = basename($new_filename);
		$this->save();

		// Move the file to the new filename path
		rename($filepath, $new_filename);

		return $this;
	}
	
	public function admin_update(& $data)
	{
		$data = Validate::factory($data)
			->rules('filename', $this->_rules['update']['filename'])
			->rules('description', $this->_rules['update']['description']);
		
		// Add validation callbacks			
		foreach($this->_callbacks['update'] as $type => $callbacks)
		{
			foreach($callbacks as $callback)
			{
				$data->callback('filename', array($this, $callback));
			}
		}
		
		if (!$data->check())
			return FALSE;

		$this->values($data);
		return $this->save();
	}
	
	public function admin_delete($id = NULL, & $data)
	{
		return parent::delete($id);		
	}
} // End Model_Asset

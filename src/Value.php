<?php

namespace Datachore;

class Value
{
	private $_value;
	
	public function __construct(\google\appengine\datastore\v4\Value $value)
	{
		$this->_value = $value;
	}
	
	public function rawValue()
	{
		switch(true)
		{
			case $this->_value->hasBooleanValue():
				return (bool)$this->_value->getBooleanValue();
			case $this->_value->hasIntegerValue():
				return (int)$this->_value->getIntegerValue();
			case $this->_value->hasDoubleValue():
				return (double)$this->_value->getDoubleValue();
			case $this->_value->hasTimestampMicrosecondsValue():
				return $this->_value->getTimestampMicrosecondsValue();
			case $this->_value->hasStringValue():
				return (string)$this->_value->getStringValue();
			
			//case $this->_value->hasEntityValue():
			//	return $this->_value->getEntityValue();
			
			// TODO: recursively echo path elements.
			case $this->_value->hasKeyValue():
				return $this->_value->getKeyValue();
			
			case $this->_value->hasGeoPointValue():
				return $this->_value->getGeoPointValue();
			
			// TODO: output a URL to the actual blob.
			case $this->_value->hasBlobKeyValue():
				return $this->_value->getBlobKeyValue();
			
			case $this->_value->hasBlobValue():
				return $this->_value->getBlobValue();
			
			/* WHAT ARE THESE?
			case $this->_value->hasMeaning():
				return $this->_value->getMeaning();
			case $this->_value->hasIndexed():
				return $this->_value->getIndexed();
			*/
			
			case $this->_value->getListValueSize() > 0:
				return $this->_value->getListValueList();
		}
	}
	
	// @CodeCoverageIgnore
	public function __toString()
	{
		switch(true)
		{
			case $this->_value->hasBooleanValue():
				return $this->_value->getBooleanValue() ? 'true' : 'false';
			case $this->_value->hasIntegerValue():
				return (string)$this->_value->getIntegerValue();
			case $this->_value->hasDoubleValue():
				return (string)$this->_value->getDoubleValue();
			case $this->_value->hasTimestampMicrosecondsValue():
				return (new \DateTime())
					->setTimestamp(
						$this->_value->getTimestampMicrosecondsValue() / (1000 * 1000)
					)
					->format(\DateTime::RFC3339);
			case $this->_value->hasStringValue():
				return $this->_value->getStringValue();
			
			// TODO: actual proper entity to model resolution
			/*
			case $this->_value->hasEntityValue():
				$entity = new $this->_value->getEntityValue();
				$className = $entity->getKind(0)->getName();
				//$model = new $className($entity);
				return "[Entity:{$classname}]";
			*/
			
			// TODO: recursively echo path elements.
			case $this->_value->hasKeyValue():
				$key = $this->_value->getKeyValue();
				
				return "[Key={partitionId: ".
						$key->getPartitionId()->getDatasetId().
						", path: {".
							'kind: '.$key->getPathElement(0)->getKind().', '.
							'id: '.$key->getPathElement(0)->getId().
						' }'.
							
					"}]";
			
			/*
			case $this->_value->hasGeoPointValue():
				$geo = $this->_value->getGeoPointValue();
				return "{lat: ".$geo->getLatitude().", y: ".$geo->getLongitude()."}";
			
			// TODO: output a URL to the actual blob.
			case $this->_value->hasBlobKeyValue():
				return $this->_value->getBlobKeyValue();
			*/
			
			case $this->_value->hasBlobValue():
				return $this->_value->getBlobValue();
			
			/* WHAT ARE THESE?
			case $this->_value->hasMeaning():
				return $this->_value->getMeaning();
			case $this->_value->hasIndexed():
				return $this->_value->getIndexed();
			*/
			
			/*
			case $this->_value->getListValueSize() > 0:
				$values = [];
				
				foreach ($this->_value->getListValueList() as $value)
				{
					$values[] = (string)$value;
				}
				
				return "[". implode(',', $values);
			*/
			
			// @codeCoverageIgnoreStart
			default:
				throw new \Exception("Unknow Type");
			// @codeCoverageIgnoreEnd
		}
	}
}

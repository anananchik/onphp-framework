<?php
/***************************************************************************
 *   Copyright (C) 2005-2006 by Anton E. Lebedevich                        *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup OSQL
	**/
	class SQLQueryJoin extends SQLBaseJoin implements SQLTableName
	{
		private	$left	= false;
		
		public function __construct(
			SelectQuery $query, LogicalObject $logic, $alias
		)
		{
			parent::__construct($query, $logic, $alias);
		}
		
		public function left()
		{
			$this->left = true;
			
			return $this;
		}

		public function toDialectString(Dialect $dialect)
		{
			return
				($this->left === true ? 'LEFT ' : null).
				'JOIN ('.$this->subject->toDialectString($dialect).') AS '.
				$dialect->quoteTable($this->alias).
				' ON '.$this->logic->toDialectString($dialect);
		}

		public function getTable()
		{
			return $this->alias;
		}
	}
?>
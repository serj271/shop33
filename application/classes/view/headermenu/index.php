<?php

class View_Headermenu_Index
{
	
		public function personalHead()
		{
			return __(Kohana::$config->load('headermenu.personal.head'));
		}
		
		public function personalHref()
		{
			return Kohana::$config->load('headermenu.personal.href');
		}
		
		public function personalviewerHead()
		{
			return __(Kohana::$config->load('headermenu.personalviewer.head'));			
		}

		public function personalviewerHref()
		{
			return Kohana::$config->load('headermenu.personalviewer.href');
			
		}
		public function intersearchHead()
		{
			return __(Kohana::$config->load('headermenu.intersearch.head'));			
		}

		public function intersearchHref()
		{
			return Kohana::$config->load('headermenu.intersearch.href');			
		}
		
		public function mrskHead()
		{
			return __(Kohana::$config->load('headermenu.mrsk.head'));			
		}

		public function mrskHref()
		{
			return Kohana::$config->load('headermenu.mrsk.href');			
		}
		
		public function chatHead()
		{
			return __(Kohana::$config->load('headermenu.chat.head'));			
		}

		public function chatHref()
		{
			return Kohana::$config->load('headermenu.chat.href');			
		}


		public function userHead()
		{
			return __(Kohana::$config->load('headermenu.user.head'));			
		}

		public function userHref()
		{
			return Kohana::$config->load('headermenu.user.href');			
		}

		public function adminNews()
		{
			return 'admin-news';			
		}


		public function adminNewsHref()
		{
			return URL::base().'admin/news';			
		}

		public function ruFlagTitle()
		{
			return Kohana::message('title-flag','ru');					
		}
   
		public function ruFlagHref()
		{
			return Kohana::$config->load('headermenu.flag.ruFlag.href');				
		}
   
   
		public function enUsFlagTitle()
		{
			return Kohana::message('title-flag','en-us');					
		}
		
		public function enUsFlagHref()
		{
			return Kohana::$config->load('headermenu.flag.enUsFlag.href');				
		}
   
   
		public function ruFlagPass(){
			$fl = Lang::instance();
		//	$fl->set('en');
			$lang = $fl->get();
			if($lang != 'ru')
			{
				return 'pass';
			}   
		}
		public function enUsFlagPass(){
			$fl = Lang::instance();
		//	$fl->set('en');
			$lang = $fl->get();
			if($lang != 'en-us')
			{
				return 'pass';
			}   
		}   
   
		public function isPersonal()
		{
			$controller =  Request::current()->controller();
			if($controller == 'personal'){
				return TRUE;				
			}
				return FALSE;		
		}
   
   
   



}
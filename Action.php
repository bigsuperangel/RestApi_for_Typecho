<?php
class RestApi_Action extends Widget_Abstract_Contents implements Widget_Interface_Do 
{

	public function execute() 
	{
	}

	public function action()
	{
		echo 'restapi invoke';
		$title=$_POST['title'];
		$text=$_POST['text'];
		$this->post_article($title,$text);
	}

	private function post_article($title,$text)
	{
		//if (!$this->user->hasLogin()) {
		//	if (!$this->user->login("admin", "admin", true)) { //使用特定的账号登陆
		//		die('fail');
		//	}
		//}
		$request = Typecho_Request::getInstance();
		//填充文章的相关字段信息。
		$request->setParams(
			array(
				'title'=>$title,
				'text'=>$text,
				'fieldNames'=>array(),
				'fieldTypes'=>array(),
				'fieldValues'=>array(),
				'cid'=>'',
				'do'=>'publish',
				'markdown'=>'1',
				'date'=>'',
				'category'=>array(),
				'tags'=>'',
				'visibility'=>'publish',
				'password'=>'',
				'allowComment'=>'1',
				'allowPing'=>'1',
				'allowFeed'=>'1',
				'trackback'=>'',		
			)
		);

		$security = $this->widget('Widget_Security');
		$request->setParam('_', $security->getToken($this->request->getReferer()));
		//设置时区，否则文章的发布时间会查8H
		date_default_timezone_set('PRC');

		$widgetName = 'Widget_Contents_Post_Edit';
		$reflectionWidget = new ReflectionClass($widgetName);

		if ($reflectionWidget->implementsInterface('Widget_Interface_Do')) {
			$this->widget($widgetName)->action();
			echo 'success';
			return;
		}	
	}
}

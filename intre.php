<?php
header('Content-type:text/html; charset=utf-8');
class Collect{
	private $pdo;
	public function __construct(){
		try{
			$this->pdo = new PDO('mysql:host=localhost;dbname=mvc','root','');
			if($this->pdo->exec('SET NAMES UTF8') === FALSE){
				throw new Exception('设置字符集有误');
			}
		}
		catch(Exception $e){
			echo 'error:'.$e->getMessage();
		}
	}

	public function getHtml(){
		include('./simple_html_dom-master/simple_html_dom.php');
		for ($i=1; $i<=10;$i++) {
				$url = "http://buy.coal.com.cn/buy/index.aspx?page=$i&jylx=1&mz=&ld=&Node=&name=&mtcq=&frl=&fr=";
				$dom = file_get_html($url);
				$trs = $dom->find('tbody tr');
				foreach ($trs as $tr) {
					$tds = $tr->find('td');
					$data = [];
					if($tds){
						foreach ($tds as $td) {
							$data[] =  $td->plaintext;
						}
						$stmts = $this->pdo->prepare('INSERT INTO `mei`(tpey,danhao,meizhong,chandi,fareliang,huifafen,huifen,liufen,shuifen,shuliang) VALUES(?,?,?,?,?,?,?,?,?,?)');
						$dataArr = [$data[0],$data[1],$data[2],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$data[10]];
						$data = $stmts->execute($dataArr);
					}else{
						continue;
					}

				}

			}if($data){
					echo '插入数据库成功';
				}else{
					echo '插入数据库失败';
				}

		}

}
$collect = new Collect;
$collect->getHtml();
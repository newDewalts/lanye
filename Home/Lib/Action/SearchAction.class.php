<?php
/**
 * 搜索控制器类
 */
class SearchAction extends CommonAction
{
	//期刊搜索
	public function yksci(){
		import('@.ORG.Page'); 
		Load('extend');
		$name = $this -> _post('name');
		$issn = $this -> _post('issn');
		$pre_cn = $this -> _post('pre_cn');
		$pre_area = $this -> _post('pre_area'); //出版地区
		$pre_create_time = $this -> _post('pre_create_time'); //创刊时间
		$order = $this -> _post('order');
		//order ( 创刊时间(date_time):desc/asc)
		
		$sql = ' 1';
		if(!empty($name)){
			$sql .= " AND pre_name LIKE '%".$name."%'";
		}
		if(!empty($issn)){
			$sql .= " AND pre_issn LIKE '%".$issn."%'";
		}
		if(!empty($pre_cn)){
			$sql .= " AND pre_cn LIKE '%".$pre_cn."%'";
		}
		if(!empty($pre_area)){
			$sql .= " AND pre_area LIKE '%".$pre_area."%'";
		}
		if(!empty($pre_create_time)){
			$sql .= " AND date_time LIKE '%".$pre_create_time."%'";
		}
		
		$orders = "orders DESC, pre_id DESC";
		if(!empty($order)){
			$orders = 'date_time ' . $order;
		}
		$count = M('periodical')->where($sql) -> count();
		$Page  = new Page($count,10);
		$result = M('periodical') -> where($sql) -> order($orders) -> limit($Page->firstRow.','.$Page->listRows) -> select();
		//dump($result);//exit;
		$this -> assign('result',$result);
		$this -> assign('pages',$Page->show());
		$this->assignSeoInfo('期刊_搜索结果','期刊搜索，中文核心期刊查询，论文期刊搜索','医学论文，中文核心期刊搜索，达晋给您最合适的医学期刊搜索结果，助力您的论文发表路程越走越远。');
		$this -> display('search');
	}

	// 高级搜索结果页
	public function advanceAction()
	{
		// 重新设置layout
		$this->layout()->setTemplate('layout/search');
		
		// 搜索条件
		$search = array(
				'name' => $this->params()->fromQuery('name'),
				'issn' => $this->params()->fromQuery('issn'),
				'sciences' => $this->params()->fromQuery('sciences'),
				'factor_max' => $this->params()->fromQuery('factor_max'),
				'factor_min' => $this->params()->fromQuery('factor_min'),
				'order'	=> $this->params()->fromQuery('order'),
		);
		
		// 期刊表网关
		$periodicalTable = $this->getServiceLocator()->get('PeriodicalTable');
		// 期刊表网关Select对象
		$select = $periodicalTable->getSelect();
		// 获取的字段
		$select->columns(array(
				'pre_id', 	'pre_name', 	'pre_image_org', 
				'pre_issn', 'pre_country', 	'pre_journal', 
				'pre_sciences', 'pre_factor'
				// , 'pre_number'
		));
		// 组合where条件的匿名函数
		$map = function (Where $where) use($search) {
			// 期刊名
			if ($search['name']) {
				$where->like('pre_name', '%' . $search['name'] . '%');
			}
			// 国际期刊号
			if ($search['issn']) {
				$where->like('pre_issn', '%' . $search['issn'] . '%');
			}
			// 科研领域
			if ($search['sciences']) {
				$where->like('pre_sciences', '%' . $search['sciences'] . '%');
			}
			// 影响因子(大于)
			if ($search['factor_min']) {
				$where->greaterThan('pre_factor', (float) $search['factor_min']);
			}
			// 影响因子(小于)
			if ($search['factor_max']) {
				$where->lessThan('pre_factor', (float) $search['factor_max']);
			}
		
			// 状态
			$where->equalTo('pre_status', 1);
			// 只搜索sci期刊
			$where->equalTo('pre_type', 0);
		};
		$select->where($map);
		
		// 默认排序
		$orders = 'orders DESC, pre_id DESC';
		
		if ($search['order']) {
			$orderArr = explode('_', $search['order']);
			if (
				(count($orderArr) == 2)
				// 允许排序的字段
				&& in_array($orderArr[0], array('factor', 'record'))
				// 允许排序的方式
				&& in_array(strtoupper($orderArr[1]), array('ASC', 'DESC'))
			) {
				// 文章数量排序
				if ($orderArr[0] == 'record') {
					$orders = 'pre_number '. strtoupper($orderArr[1]);
				}
				// 影响因子排序
				if ($orderArr[0] == 'factor') {
					$orders = 'pre_factor '. strtoupper($orderArr[1]);
				}
			}
		}
		$select->order($orders);
		
		// 分页获取数据
		$paginator = $periodicalTable->getPaginator($select);
		// 设置当前页
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		// 设置每页显示数量
		$paginator->setItemCountPerPage(10);
	
		$viewModel = new ViewModel;
		
		// 赋值SEO信息
		$seoInfo = array('title' => '搜索结果', 'keywords' => '', 'description' => '');
		
		$viewModel->setVariable('seoInfo', $seoInfo);
		$viewModel->setVariable('search', $search);
		$viewModel->setVariable('paginator', $paginator);
		
		return $viewModel;
	}
	
	// 选刊助手搜索结果页
	public function selectAction()
	{
		// 重新设置layout
		$this->layout()->setTemplate('layout/search');
		
		// 获取选刊的文本
		$content = trim($this->getRequest()->getPost('content'));
		
		$matchPeriodical = array();
		
		if ($content) {
			// 获取匹配处理对象
			$searchTextMatchDegree = $this->getServiceLocator()->get('SearchTextMatchDegree');
			// 设置匹配文本
			$searchTextMatchDegree->setMatchText($content);
			// 获取匹配度
			$matchDegree = $searchTextMatchDegree->getMatchDegree();
			
			if (count($matchDegree) > 20) {
				// 最多显示20条记录
				$matchDegree = array_slice($matchDegree, 0, 20, true);
			}
			
			// 有匹配的期刊
			if (!empty($matchDegree)) {
				
				$preIds = implode(',', array_keys($matchDegree));
				
				$sql = 'SELECT pre_id, pre_name, pre_image_org, pre_issn, pre_country, pre_journal, pre_sciences, pre_factor FROM yk_periodical WHERE pre_status=1 AND pre_type=0 AND pre_id IN (' . $preIds . ') ORDER BY field(pre_id,' . $preIds . ')';
	
				$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
				$statement = $dbAdapter->query($sql);
				$resultSet = $statement->execute();
				
				foreach ($resultSet as $row) {
					$row['match_degree'] = $matchDegree[$row['pre_id']];
					$matchPeriodical[] = $row;
				}
			}
		}

		$viewModel = new ViewModel;
		
		// 赋值SEO信息
		$seoInfo = array('title' => '选刊结果', 'keywords' => '', 'description' => '');

		$viewModel->setVariable('seoInfo', $seoInfo);
		$viewModel->setVariable('matchPeriodical', $matchPeriodical);
		
		return $viewModel;
	}
	
	
	/**
	 * 头部导航位置的搜索
	 * 
	 * @return ViewModel
	 */
	public function sAction()
	{
		// 允许搜索的选项
		$allowOptions = array('name', 'sciences', 'issn', 'cn');
		
		/*
		if (!$this->getRequest()->isPost()) {
			return $this->notFoundAction();
		}
		*/
		
		// 搜索选项与值
		$sCondition = array(
				'option' => $this->getRequest()->getPost('option', 'name'),
				'value'  => $this->getRequest()->getPost('value')
		);
		
		if (!in_array($sCondition['option'], $allowOptions)) {
			$sCondition['option'] = 'name';
		}
		
		// 期刊表模型
		$periodicalTable = $this->getServiceLocator()->get('PeriodicalTable');
		// 期刊表网关Select对象
		$select = $periodicalTable->getSelect();
		// 获取的字段
		$select->columns(array('pre_id', 'pre_name', 'pre_image_org'));
		// 组合where条件的匿名函数
		$map = function (Where $where) use($sCondition) {
			// 期刊名
			if ($sCondition['option'] == 'name') {
				$field = 'pre_name';
			}
			// 国际期刊号
			if ($sCondition['option'] == 'issn') {
				$field = 'pre_issn';
			}
			// 科研领域
			if ($sCondition['option'] == 'sciences') {
				$field = 'pre_sciences';
			}
			// 国内期刊号
			if ($sCondition['option'] == 'cn') {
				$field = 'pre_cn';
			}
			$where->like($field, '%' . $sCondition['value'] . '%');
			// 状态
			$where->equalTo('pre_status', 1);
		};
		$select->where($map);
		// 排序
		$select->order('orders DESC, pre_id DESC');
		// 硬性限制在150以内
		$select->limit(150);
		
		// 获取搜索数据
		$searchResult = $periodicalTable->getCacheData($select);
		
		// 赋值SEO信息
		$seoInfo = array(
				'title' => $sCondition['value'],
				'keywords' => '',
				'description' => ''
		);
		
		// 赋值到模板
		return new ViewModel(array(
				'seoInfo' => $seoInfo,
				'sCondition' => $sCondition,
				'searchResult' => $searchResult
		));
	}
	
}
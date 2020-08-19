<?php



/**
 * php实现各种排序算法
 */
class Sort {
	private $arr = [];
	private $size;

	//生成随机数组
	public function __construct($size)
	{
		$this->size = $size;
		$this->randArr();
	}

	//冒泡排序，比较相邻元素，如果前面比后面小，交互位置
	//一轮比较之后最大的元素在最后面
	//第一次循环比较n-1次，第二次循环n-2次...
	public function bubble()
	{
		$count = count($this->arr);
		if ($count <= 1) return;
		for ($i=0; $i < $count; $i++) { 
			for ($j=0; $j < $count - $i -1; $j++) { 
				if ($this->cmp($j, $j+1) > 0) {
					$this->exch($j, $j+1);
				}
			}
		}
	}

	//选择排序，假定第一个元素是最小元素，循环比较，如果比他小，交换
	//一轮比较之后最小的元素在最前面
	//可以用双指针理解
	public function selection()
	{
		$count = count($this->arr);
		if ($count <= 1) return;
		for ($i=0; $i < $count; $i++) { 
			$min = $this->arr[$i];
			for ($j=$i+1; $j < $count; $j++) { 
				if ($this->cmp($i, $j) > 0) {
					$this->exch($i, $j);
				}
			}
		}
	}

	//插入排序 假定数组是有序的，然后遍历将数组插入到相应位置
	public function insertion()
	{
		$count = count($this->arr);
		if ($count <= 1) return;
		for ($i=1; $i < $count; $i++) { 
			//将i插入到i-1,i-2...0中
			for ($j=$i; $j>0 && ($this->cmp($j, $j-1) < 0); $j--) {//待插入元素比$j-1小，交换 
				$this->exch($j, $j-1);
			}
		}
	}

	//快速排序，比元素<一般取数组第一个元素>小的放左边，大的放右边，然后合并<分治思想，递归>
	public function quick()
	{
		$this->arr = $this->quickInternal($this->arr);
	}

	//快排实现
	private function quickInternal($arr)
	{
		$count = count($arr);
		if ($count <= 1) return $arr;
		$mid = $arr[0];
		$left = $right = [];
		for ($i=1; $i < $count; $i++) { 
			if ($this->cmpV($mid, $arr[$i]) > 0) {
				array_push($left, $arr[$i]);
			} else {
				array_push($right, $arr[$i]);
			}
		}

		return array_merge($this->quickInternal($left), [$mid], $this->quickInternal($right));
	}


	//归并排序,将数组分为一块一块，然后对一块一块进行比较排序<分治思想，递归>
	//例：[5,6,2,8,10,3]
	//=>[5,6,2] [8,10,3]
	//=>[5],[6,2] [8],[10,3]
	//=>[5],[2,6] [8],[3,10]
	//=>[2,5,6] [3,8,10]
	//=>[2,3,5,6,8,10]
	public function merge()
	{
		$this->arr = $this->mergeSortInternal($this->arr);
	}

	private function mergeSortInternal($arr)
	{
		$count = count($arr);
		if ($count <= 1) return $arr;
		$mid = intval($count>>1);
		$left = array_slice($arr, 0, $mid);
		$right = array_slice($arr, $mid);
		$left = $this->mergeSortInternal($left);//分
		$right = $this->mergeSortInternal($right);

		return $this->mergeInternal($left, $right);//合
	}

	//合并操作，从头比较数组元素，弹出小的放入返回数组里面，
	//如果一个数组为空，剩下的非空拼接到返回数组里
	private function mergeInternal($arr1, $arr2)
	{
		$arr = [];
		while (!empty($arr1) && !empty($arr2)) {
			$arr[] = $arr1[0] < $arr2[0] ? array_shift($arr1) : array_shift($arr2); 
		}
	
		return array_merge($arr, $arr1, $arr2);
	}

	//比较
	private function cmp($i1, $i2)
	{
		return $this->arr[$i1] > $this->arr[$i2] ? 1 : ($this->arr[$i1] == $this->arr[$i2] ? 0 : -1);
	}

	private function cmpV($n1, $n2) 
	{
		return $n1 > $n2 ? 1 : ($n1 == $n2 ? 0 : -1);
	}

	//交换
	private function exch($i1, $i2)
	{
		$temp = $this->arr[$i1];
		$this->arr[$i1] = $this->arr[$i2];
		$this->arr[$i2] = $temp;
	}

	//生成随机数组
	private function randArr()
	{
		for ($i=0; $i < $this->size; $i++) { 
			array_push($this->arr, rand(1,100));
		}
		echo "create random array:\r\n";
		echo '[' . implode(',', $this->arr) . ']';
		echo "\r\n";
	}

	//打印
	public function show()
	{
		echo "sorted array:\r\n";
		echo '[' . implode(',', $this->arr) . ']';
		echo "\r\n";
	}
}


$sort = new Sort(10);
//$sort->bubble();
//$sort->selection();
//$sort->insertion();
//$sort->quick();
$sort->merge();
$sort->show();

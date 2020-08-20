<?php

//回溯算法
//wiki:回溯法（英语：backtracking）是暴力搜索法中的一种。
/*对于某些计算问题而言，回溯法是一种可以找出所有（或一部分）解的一般性算法，尤其适用于约束补偿问题（在解决约束满足问题时，我们逐步构造更多的候选解，并且在确定某一部分候选解不可能补全成正确解之后放弃继续搜索这个部分候选解本身及其可以拓展出的子候选解，转而测试其他的部分候选解）。
在经典的教科书中，八皇后问题展示了回溯法的用例。（八皇后问题是在标准国际象棋棋盘中寻找八个皇后的所有分布，使得没有一个皇后能攻击到另外一个。）
回溯法采用试错的思想，它尝试分步的去解决一个问题。在分步解决问题的过程中，当它通过尝试发现现有的分步答案不能得到有效的正确的解答的时候，它将取消上一步甚至是上几步的计算，再通过其它的可能的分步解答再次尝试寻找问题的答案。回溯法通常用最简单的递归方法来实现，在反复重复上述的步骤后可能出现两种情况：
找到一个可能存在的正确的答案
在尝试了所有可能的分步方法后宣告该问题没有答案
在最坏的情况下，回溯法会导致一次复杂度为指数时间的计算。*/


//lettcode51. N皇后
//n 皇后问题研究的是如何将 n 个皇后放置在 n×n 的棋盘上，并且使皇后彼此之间不能相互攻击。
//给定一个整数 n，返回所有不同的 n 皇后问题的解决方案。
//每一种解法包含一个明确的 n 皇后问题的棋子放置方案，该方案中 'Q' 和 '.' 分别代表了皇后和空位。
class NQueens {

	//摆放数组，键代表行，值代码列 例：cols[1] = 2;//第二行第三列有皇后
	public $cols;

	public $res;

    /**
     * @param Integer $n
     * @return String[][]
     */
    function solveNQueens($n) {
        if ($n < 1) return;
        //$this->cols = new SplFixedArray($n);//push时候出问题
        $this->cols = array_fill(0, $n, 0);
        $this->place(0);

        return $this->res;
    }

    //第row行摆放
    private function place($row)
    {
    	if ($row == count($this->cols)) {//所有行都摆放了皇后
    		$result = $this->cols;
			foreach($result as $k => $v) {
				$temp = array_fill(0, count($this->cols), '.');
				$temp[$v] = 'Q';
				$result[$k] = implode('', $temp);
			}
			$this->res[] = $result;
    		return;
    	}
    	for ($col=0; $col < count($this->cols); $col++) {
    		if ($this->isValid($row, $col)) {//可以摆放，存储位置，跳到下一行摆放
    			$this->cols[$row] = $col;
    			$this->place($row+1); //回溯操作，下一行如果不满足，继续上一行的for循环
    		}
    	}
    }

    //检验位置是否可以放置<不在同一列和同一对角线>
    private function isValid($row, $col)
    {
    	for ($i=0; $i < $row; $i++) { 
    		if ($this->cols[$i] == $col) return false;//同一行
    		//判断是否在一条斜线上 (x1-x2)/(y1-y2) = (1 or -1)
    		if ($row - $i == abs($col - $this->cols[$i])) return false; //同一对角线
    	}
    	return true;
    }
}

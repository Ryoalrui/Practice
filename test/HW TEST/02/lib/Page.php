<?php
/*分页展示类*/
ini_set('display_errors', 0);

class Page
{
    protected $number;//每页显示的数据条数
    protected $totalCount;//全部数据条数
    public $page;//当前页码
    protected $totalPage;//总页数
    protected $url;//url
    protected $scheme;//当前网页协议
    protected $host;//当前网页主机
    protected $port;//当前网页端口


    public function __construct($number, $totalCount)
    {
        $this->number = $number;//得到每页显示的数据条数
        $this->totalCount = $totalCount;//得到全部数据条数
        $this->totalPage = $this->getTotalPage();//得到总页数
        $this->page = $this->getPage();//得到当前页码
        $this->url = $this->getUrl();//得到当前的url
        // echo $this->getUrl();
    }

    /**
     * [计算总页数]
     * @method getTotalPage
     */
    protected function getTotalPage()
    {
        return ceil($this->totalCount / $this->number);
    }

    /**
     * [判断当前页码的得到]
     * @method getPage
     */
    protected function getPage()
    {
        if (empty($_GET['page']) || ($_GET['page'] < 1)) {
            $page = 1;
        } elseif ($_GET['page'] > $this->totalPage) {
            $page = $this->totalPage;
        } else {
            $page = $_GET['page'];
        }
        return $page;
    }

    /**
     * [获取链接各部分参数，并拼接初始化链接]
     * @method getUrl
     * @return [string] [初始化url]
     */
    protected function getUrl()
    {
        $this->scheme = $_SERVER['REQUEST_SCHEME'];//得到协议名
        $this->host = $_SERVER['SERVER_NAME'];//得到主机名
        $this->port = $_SERVER['SERVER_PORT'];//得到端口号
        $uri = $_SERVER['REQUEST_URI'];//得到请求路径和请求字符串

        //清空原有url中的page参数,在拼接回去
        $uriArray = parse_url($uri);
        $path = $uriArray['path'];
        if (!empty($uriArray['query'])) {         //如果链接中查询参数不为空
            parse_str($uriArray['query'], $array);//将其打散成关联数组
            unset($array['page']);                //清空数组中的page部分
            $query = http_build_query($array);    //重新组成链接
            if ($query!='') {                     //链接不为空的情况，进行拼接
                $path = $path.'?'.$query;
            }
        }
        return $this->scheme.'://'.$this->host.':'.$this->port.$path;
    }

    /**
     * [展示所有的url]
     * @method allUrl
     * @return [array] [链接数据]
     */
    public function allUrl()
    {
        return [
          'first'=>$this->first(),
          'end'=>$this->end()
        ];
    }

    /**
     * [得到首页超链接]
     * @method first
     * @return [string] [首页链接地址]
     */
    public function first()
    {
        //判断当前链接地址是否已含有查询参数,拼接 初始化链接 + 首页页码
        if (strstr($this->url, '?')) {
            return $this->url = $this->url.'&page=1';
        } else {
            return $this->url = $this->url.'?page=1';
        }
    }


    /**
     * [得到尾页超链接]
     * @method end
     * @return [string] [尾页链接地址]
     */
    public function end()
    {
        if (strstr($this->url, '?')) {
            $uriArray = parse_url($this->url);
            $path = $uriArray['path'];
            if (!empty($uriArray['query'])) {         //如果链接中查询参数不为空
                parse_str($uriArray['query'], $array);//将其打散成关联数组
                unset($array['page']);                //清空数组中的page部分
                $query = http_build_query($array);    //重新组成链接
                if ($query!='') {                     //链接不为空的情况，进行拼接
                    $path = $path.'?'.$query;
                    $this->url =  $this->scheme.'://'.$this->host.':'.$this->port.$path;//初始化链接
                    return $this->url = $this->url.'&page='.$this->totalPage;
                } else {
                    return $this->url = $this->scheme.'://'.$this->host.':'.$this->port.$path.'?page='.$this->totalPage;
                }
            }
        }
    }

    /**
     * [查询范围]
     * @method limit
     * @return [string]
     */
    public function limit()
    {
        //limit 0,5 limit 5,5
        $offset = ($this->page-1)*($this->number);
        return $offset.','.$this->number;
    }
}
// $page = new Page(9, 12);
// $links = $page->allUrl();
// echo $links['first'];
// echo $links['end'];
// echo $page->limit();

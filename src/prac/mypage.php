<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .nav{
            height: 70px;
            border-bottom: 1px solid black;
            display: flex;
            align-items: center;
        }

        .nav-right-items{
            display: flex;
            margin-left: auto;
        }

        .nav-item {
            margin-left: 10px;
        }

        .title {
            font-size: 3.5rem;
            font-weight: bold;
            text-align: center;

        }

        .subtitle{
            font-size: 1.25rem;
            font-weight: 300;
            text-align: center;
        }

        .main{
            margin-top: 60px;
            width: 800px;
            margin: 0 auto;
        }

        .prices{
            display: flex;
        }

        .price-item{
            width: 300px;
            height: 300px;
            border: 1px solid black;
            margin: 20px;
            border-radius: 4px;
        }
        
        .price-item-title{
            font-size: 1.5rem;
            background: rgba(0,0,0,.03);
            text-align: center;
            height: 53px;
            line-height: 53px;
            border-bottom: 1px solid black;
        }

        .price-item-price{
            font-size: 2rem;
            font-weight: bold;
            padding: 15px;

        }

        .price-item-button{
            padding: .5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
            margin-top: 40px;
            color: #007bff;
            background-color: transparent;
            background-image: none;
            border-color: #007bff;
        }
    </style>

</head>
<body>
    <div class="nav">
        <div class="nav-right-items">
            <div class="nav-item">메뉴1</div>
            <div class="nav-item">메뉴2</div>
            <div class="nav-item">메뉴3</div>
            <div class="nav-item">메뉴4</div> 
        </div>
    </div>
    <div class="main">
        <div class="title">
            무슨 커뮤니티
        </div>
        <div class="subtitle">
            기획의도가 확실하진않고 차차 만들어나갈 예정입니다.
        </div>

        <div class ="prices">
            <div class="price-item">
                <div class ="price-item-title">
                    제목 1
                </div>
                <div class="price-item-price">
                    소제목1
                </div>
                <div class="price-item-detail">
                    관련 디테일1 내용입니다 
                </div>
                <button class="price-item-button">
                    1번 클릭해주세요
                </button>
            </div>
            <div class="price-item">
                <div class ="price-item-title">
                    제목 2
                </div>
                <div class="price-item-price">
                    소제목2
                </div>
                <div class="price-item-detail">
                    관련 디테일2 내용입니다 
                </div>
                <button class="price-item-button">
                    2번 클릭해주세요
                </button>
            </div>
            <div class="price-item">
                <div class ="price-item-title">
                    제목 3
                </div>
                <div class="price-item-price">
                    소제목3
                </div>
                <div class="price-item-detail">
                    관련 디테일3 내용입니다 
                </div>
                <button class="price-item-button">
                    3번 클릭해주세요
                </button>
            </div>
            <div class="price-item">
                <div class ="price-item-title">
                    제목 4
                </div>
                <div class="price-item-price">
                    소제목4
                </div>
                <div class="price-item-detail">
                    관련 디테일4 내용입니다 
                </div>
                <button class="price-item-button">
                    4번 클릭해주세요
                </button>
            </div>
    
        </div>
    </div>
    

</body>
</html>
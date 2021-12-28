function order_complete(j,od_id){
    console.log("처리처리");
    if (confirm("주문을 완료 처리 하시겠습니까?") == true){
        fetch('http://192.168.80.130/back/php/order_finish.php?od_id='+od_id)
        .then((res) => res.text())
        .then((data) => {
            console.log(data);
            // alert("처리완료")
            // location.href='http://192.168.80.130/front/html/shop_order_check.php';
            const btn_done = document.getElementById('od_complete'+j);
            btn_done.innerText = "처리완료";
            btn_done.style.color = "white";
            btn_done.style.border = "none";
            btn_done.style.backgroundColor = "green";
            window.location.reload();
        });
    } else {
        return;
    }
}



function load_data(page,bool) {
    if (bool == 0){ //데이터 끝나면 스크롤을 멈춘다.
        fetch('http://192.168.80.130/back/php/load_data.php?page='+now_page+'&end='+bool)
        .then((res) => res.text())
        .then((data) => {
            switch(data){
                case 'false':{ //불러올게 없을떄
                    console.log(data);
                    console.log(now_page);
                }
                default:{ //데이터 불러올떄
                    data1 = JSON.parse(data);
                    console.log(data1);
                    console.log(now_page);
                    now_page = now_page + 1;
                    end = data1[0][0];
                }
            }
        });

        var tr = document.getElementById('list');
        var td2 = document.createElement('td');
        //td2.setAttribute('class','date');
        //td2.setAttribute('value','22222222')
        tr.appendChild(td2);
        document.body.appendChild(tr);

    }
    
}

// const options = {
// root: null, // 또는 scrollable 한 element root: document.querySelector('#scrollArea'),
// rootMargin: '10px', // 기본값 0px 상우하좌
// threshold: 0.5 // 0.0 ~ 1.0 사이의 숫자. 배열도 가능
// }

let now_page = 0;
let end = 0;

const io = new IntersectionObserver((entries,observer) => {
    entries.forEach(entry => {
        //   console.log('entry:',entry);
        //   console.log('observer:',observer);
        // 관찰 대상이 viewport 안에 들어온 경우 'tada' 클래스를 추가
        if (entry.intersectionRatio > 0) {
            // entry.target.classList.add('tada');
            console.log("들어왔음");
            load_data(now_page,end);
        }
        // 그 외의 경우 'tada' 클래스 제거
        else {
            // entry.target.classList.remove('tada');
            console.log("그외는 삭제");
        }
    })
});

// 관찰할 대상을 선언하고, 해당 속성을 관찰시킨다.
const boxElList = document.querySelectorAll('.empty');
boxElList.forEach((el) => {
    console.log("io.observe실행");
    io.observe(el);
})





// function YesScroll() {
//     //페이지네이션 정보획득
//     const pagination = document.querySelector('.pagination');
//     //전체 컨텐츠 정보 획득
//     const fullContent = document.querySelector('.infinite');
//     //화면크기
//     const screenHeight = screen.height;
//     //일회용 글로벌 변수
//     let oneTime = false;
//     //e.preventDefault와는 같이 사용불가능 (passive:true) ->메인스레드 안써서 그럼
//     //이벤트 처리와 별도로 컴포지터 스레드에서 composite를 수행해서 스크롤이 향상된다.
//     document.addEventListener('scroll',OnScroll,{passive:true})
//     function OnScroll(){ //스크롤 이벤트 함수
//         //infinite class의 높이
//         const fullHeight = fullContent.clientHeight;
//         //스크롤 위치
//         const scrollPosition = pageYOffset;

//         if(fullHeight-screenHeight/2 <= scrollPosition && !oneTime){
//             oneTime = true;
//             madeBox(); //컨텐츠 추가하는 함수를 불러온다
//         }
//     }
//     function madeBox(){

//     }
// }

// YesScroll();
function order_complete(od_id){
    console.log("처리처리");
    console.log(od_id);
    if (confirm("주문을 완료 처리 하시겠습니까?") == true){
        fetch('http://192.168.80.130/back/php/order_finish.php?od_id='+od_id)
        .then((res) => res.text())
        .then((data) => {
            console.log(data);
            // alert("처리완료")
            // location.href='http://192.168.80.130/front/html/shop_order_check.php';
            const btn_done = document.getElementById('od_complete'+od_id);
            btn_done.innerText = "처리완료";
            btn_done.style.color = "white";
            btn_done.style.border = "none";
            btn_done.style.backgroundColor = "green";
            //window.location.reload();
        });
    } else {
        return;
    }
}



function load_data(page,bool) {
    if (bool == 0){ //데이터 끝나면 스크롤을 멈춘다.
        fetch('http://192.168.80.130/back/php/load_data.php?page='+now_page+'&end='+bool+'&cdate='+cdate+'&exist='+exist)
        .then((res) => res.text())
        .then((data) => {
            switch(data){
                case 'false':{ //불러올게 없을떄
                    console.log(data);
                    console.log(now_page);
                    io.disconnect();
                }
                default:{ //데이터 불러올떄
                    data1 = JSON.parse(data);
                    console.log(data1);
                    console.log(now_page);
                    now_page = now_page + 1;
                    end = data1[0][0];

                    data_len = data1.length;

                    cdate = data1[data_len-1][12];
                    exist = data1[data_len-1][13];
                    

                    let tbody = document.getElementById('infinite');

                    for (var i = 0; i < data_len; i++) {
                        
                        let tr = document.createElement('tr');
                        // let tr = document.createElement('tr');
                        let td2 = document.createElement('td');
                        td2.setAttribute('class','date');

                        let td3 = document.createElement('td');
                        td3.setAttribute('class','tit');

                        let td4 = document.createElement('td');
                        td4.setAttribute('class','price');

                        let td5 = document.createElement('td');
                        td5.setAttribute('class','consumer');
                        
                        let div_name = document.createElement('div');
                        let div_email = document.createElement('div');
                        let div_phone_number = document.createElement('div');
                        let div_address_post = document.createElement('div');
                        let div_address_detail = document.createElement('div');
                        
                        div_name.innerHTML = data1[i][4];
                        div_email.innerHTML = data1[i][5];
                        div_phone_number.innerHTML = data1[i][6];
                        div_address_post.innerHTML = data1[i][7];
                        div_address_detail.innerHTML = data1[i][8] +" "+ data1[i][9];

                        td5.appendChild(div_name);
                        td5.appendChild(div_email);
                        td5.appendChild(div_phone_number);
                        td5.appendChild(div_address_post);
                        td5.appendChild(div_address_detail);


                        let td6 = document.createElement('td');
                        td6.setAttribute('class','done');

                        let td7 = document.createElement('td');
                        td7.setAttribute('class','idd');

                        if (data1[i][10] == 0){
                            //console.log("0들어옴");
                            let span_done = document.createElement('span');
                            span_done.setAttribute('class','process');
                            span_done.setAttribute('id','od_complete'+data1[i][11]);
                            //span_done.setAttribute('onclick',order_complete(data1[i][11]));
                            //span_done.onclick=order_complete(data1[i][11]);
                            td7.setAttribute('id','od_id'+data1[i][11])
                            td7.innerHTML = data1[i][11];
                            //od_fid = data1[i][11];
                            span_done.onclick = function() {
                                const od_fff = document.getElementById('od_id'+td7.innerHTML).innerHTML;
                                console.log(od_fff);
                                order_complete(od_fff)};
                            span_done.innerHTML = "미처리";
                            td6.appendChild(span_done);
                        } else {
                            //console.log("1들어옴");
                            let span_done = document.createElement('span');
                            span_done.setAttribute('class','finish');
                            span_done.setAttribute('id','od_complete'+data1[i][11]);
                            span_done.innerHTML = "처리완료";
                            td6.appendChild(span_done);
                        }

                        td2.innerHTML = data1[i][1];
                        td3.innerHTML = data1[i][2];
                        td4.innerHTML = data1[i][3].toLocaleString('ko-KR')+"원";
                        //td5.innerHTML = "구매자정보";
                        //td6.innerHTML = data1[i][10];

                        
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        tr.appendChild(td4);
                        tr.appendChild(td5);
                        tr.appendChild(td6);
                        tr.appendChild(td7);

                        tbody.appendChild(tr);

                    }
                    let tr_empty = document.createElement('tr');
                    tr_empty.setAttribute('class','empty');
                    tr_empty.setAttribute('id','empty'+now_page);

                    tbody.appendChild(tr_empty);

                    changeTarget(now_page);
                }
            }
        });



    }
    
}

// const options = {
// root: null, // 또는 scrollable 한 element root: document.querySelector('#scrollArea'),
// rootMargin: '10px', // 기본값 0px 상우하좌
// threshold: 0.5 // 0.0 ~ 1.0 사이의 숫자. 배열도 가능
// }

let now_page = 1;
let end = 0;
let cdate = 0;
let exist = 0;

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

function changeTarget(npage) {
    io.disconnect();
    console.log("타겟들어옴");
    nid = "empty" + npage;
    io.observe(document.getElementById(nid));
}
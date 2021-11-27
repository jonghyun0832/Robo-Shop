var checkBoxList = new Array(false,false,false,false,false,false,false);
function execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function (data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수

            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
            if (data.userSelectedType === 'R') {
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                    extraAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if (data.buildingName !== '' && data.apartment === 'Y') {
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if (extraAddr !== '') {
                    extraAddr = ' (' + extraAddr + ')';
                }
                // 조합된 참고항목을 해당 필드에 넣는다.
                document.getElementById("user_extraAddress").value = extraAddr;

            } else {
                document.getElementById("user_extraAddress").value = '';
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            document.getElementById('postcode').value = data.zonecode;
            document.getElementById("user_address").value = addr;
            // 커서를 상세주소 필드로 이동한다.
            document.getElementById("user_detailAddress").focus();
        }
    }).open();
}

//아이디 중복확인, 아이디 길이 확인
function idEqualCheck(){
    var cb = false;
    const input_id = document.getElementById('id').value;

    if(input_id ===''){
        alert("아이디를 입력하세요");
        return;
    }
    
    fetch('http://192.168.80.130/back/php/shop_id_check.php',{
        method:'POST',
        cache:'no-cache',
        headers:{
            'Content-Type':'application/json; charset=utf-8'
        },
        body: JSON.stringify({
            id : input_id
        })
    })
    .then((res) => res.text())
    .then((data) => {
        console.log(data);
        switch(data){
            case 'true' : {
                if (input_id.length <4){
                    alert("아이디는 최소 4자 이상입니다")
                    document.getElementById('cb_id').checked = false;
                    checkBoxList[0]=false;
                }
                else {
                    alert("사용 가능한 아이디입니다.")
                    document.getElementById('cb_id').checked = true;
                    checkBoxList[0]=true;
                }
                break;
            }
            case 'false' : {
                if (input_id.length <4){
                    alert("아이디는 최소 4자 이상입니다")
                    document.getElementById('cb_id').checked = false;
                    checkBoxList[0]=false;
                }
                else {
                    alert("사용 불가능한 아이디입니다.")
                    document.getElementById('cb_id').checked = false;
                    checkBoxList[0]=false;
                }
                break;
            }
        }
    });
    //.catch(err =>console.log(err))
    //아이디 중복체크하고나서
    
    console.log(checkBoxList);
}
//패스워드 길이 확인
function passwordLengthCheck(){
    var pw1 = document.getElementById('pw').value;
    

    console.log(1111)
    if(pw1.length < 6){
        alert('비밀번호는 최소 6자 이상입니다')
        document.getElementById('cb_pw').checked = false;
        checkBoxList[1]=false;
    } else{
        document.getElementById('cb_pw').checked = true;
        checkBoxList[1]=true;
    }
    console.log(checkBoxList);
}
//비밀번호 일치 확인
function passwordEqualCheck(){
    var pw1 = document.getElementById('pw').value;
    var pw2 = document.getElementById('pw_check').value;
    
    if(pw1 != pw2){
        alert('비밀번호 불일치')
        document.getElementById('cb_pw_check').checked = false;
        checkBoxList[2]=false;
    } else {
        document.getElementById('cb_pw_check').checked = true;
        checkBoxList[2]=true;
    }
    console.log(checkBoxList);
}
function nameCheck(){
    var userName = document.getElementById('user_name').value;

    if (userName.length>= 1){
        document.getElementById('cb_name').checked = true;
        checkBoxList[3]=true;
    } else {
        document.getElementById('cb_name').checked = false;
        checkBoxList[3]=false;
    }
    console.log(checkBoxList);
}
//이메일 입력 체크하기
function emailCheck(){
    var usrEmail = document.getElementById('user_email').value;
    console.log(usrEmail);
    var usrEamilAddress;
    var usrEamilSiteAddress;
    //이메일 형식 확인 (@)
    if (usrEmail.indexOf("@") !=-1){
        var arrEmail = usrEmail.split('@')
        usrEamilAddress = arrEmail[0];
        usrEamilSiteAddress = arrEmail[1]
        //이메일 형식 확인(.com)
        if (usrEamilSiteAddress.indexOf(".com")!=-1){
            document.getElementById('cb_email').checked = true;
            checkBoxList[4]=true;
            //sql로 넘겨서 저장하기 수행
        } else{
            document.getElementById('cb_email').checked = false;
            checkBoxList[4]=false;
            alert('이메일 형식(xxxx@xxx.com)으로 입력해주세요.')
        }
    } else {
        document.getElementById('cb_email').checked = false;
        checkBoxList[4]=false;
        alert('이메일 형식(xxxx@xxx.com)으로 입력해주세요.')
    }
    console.log(checkBoxList);
}
//핸드폰 번호 체크하기
function phoneCheck(){
    var usrPhone = document.getElementById('user_phone').value;
    if (usrPhone.length <10){
        alert("-를 제외한 핸드폰 번호를 입력해주세요\n010-1234-5678 -> 01012345678")
        document.getElementById('cb_phone').checked = false;
        checkBoxList[5]=false;
    } else {
        document.getElementById('cb_phone').checked = true;
        checkBoxList[5]=true;
    }
    console.log(checkBoxList);
}
//주소 확인하기
function checkAddress(){
    var addCheckPost = document.getElementById('postcode').value;
    var addCheckDetail = document.getElementById('user_detailAddress').value;
    
    if (addCheckPost.length >= 1 && addCheckDetail.length >= 1){
        document.getElementById('cb_address').checked = true;
        checkBoxList[6]=true;
    } else if(addCheckPost.length >= 1 && addCheckDetail.length == 0){
        document.getElementById('cb_address').checked = false;
        checkBoxList[6]=false;
        alert("상세주소를 입력해주세요")
    } else {
        document.getElementById('cb_address').checked = false;
        checkBoxList[6]=false;
        alert("전체 주소를 입력해주세요")
    }
    console.log(checkBoxList);
}
//회원가입 버튼 눌렀을때
function createAccount(){
    if(checkBoxList.includes(false) == true){
        alert("모든 정보를 입력해주세요\n체크박스를 확인해주세요")
    }
    else {
        //모든 정보가 입력되었고 이제 post를 활용해서 보내면된다.
        console.log("모든정보가 들어있음")

        //보낼 데이터 정리
        var userData = {
            'usr_id' : document.getElementById('id').value,
            'usr_pw' : document.getElementById('pw').value,
            'usr_name' : document.getElementById('user_name').value,
            'usr_email' : document.getElementById('user_email').value,
            'usr_phoneNum' : document.getElementById('user_phone').value,
            'usr_addPost' : document.getElementById('postcode').value,
            'usr_addAddress' : document.getElementById('user_address').value,
            'usr_addDetail' : document.getElementById('user_detailAddress').value,
            'usr_addExtra' : document.getElementById('user_extraAddress').value
        };

        var newForm = document.createElement('form');
        newForm.name = 'newForm';
        newForm.method = 'post';
        newForm.action = 'http://192.168.80.130/back/php/shop_account_admin.php';
        // newForm.target = '_blank';
        for (var key in userData){
        var input_data = document.createElement('input');

        input_data.setAttribute("type", "text");
        input_data.setAttribute("name",key);
        input_data.setAttribute("value",userData[key]);

        newForm.appendChild(input_data);
        }
        document.body.appendChild(newForm);

        newForm.submit();



        // const xhr = new XMLHttpRequest(); 
        // const method = "GET"; 
        // const url = "http://192.168.80.130/account_admin.php";

        // const data = {
        //     id = document.getElementById('id').value,
        //     // pw = document.getElementById('pw').value,
        //     // name = document.getElementById('user_name').value,
        //     // email = document.getElementById('user_email').value,
        //     // phoneNum = document.getElementById('user_phone').value,
        //     // addPost = document.getElementById('postcode').value,
        //     // addAddress = document.getElementById('user_address').value,
        //     // addDetail = document.getElementById('user_detailAddress').value,
        //     // addExtra = document.getElementById('user_extraAddress').value
        // };

        // xhr.open(method, url);
        // xhr.setRequestHeader('Content-Type', 'application/json');
        // xhr.addEventListener('readystatechange',function(event){
        //     const {target} = event;

        //     if (target.readyState === XMLHttpRequest.DONE) {
        //         const {status} = target;

        //         if (status === 0 || (status >= 200 && status < 400)) {
        //             //제대로 처리된경우
        //         } else {
        //             //에러발생
        //         }
        //     }
        // });
        // xhr.send(JSON.stringify(data));
    }
}
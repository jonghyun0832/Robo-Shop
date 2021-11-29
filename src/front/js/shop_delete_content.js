function delete_content() {
    console.log('dsdsdsd');
    if (confirm("정말 삭제하시겠습니까?") == true){
        //삭제
        fetch('http://192.168.80.130/back/php/delete_content.php' + "?user_id =" + document.getElementById('content_user_id').value)
        .then((res) => res.text())
        .then((data) => {
            console.log(data);
            alert("삭제가 완료되었습니다.")
            location.href='http://192.168.80.130/front/html/shop_customer_question.php';
        });
    } else{
        return;
    }
    //딜리트하면 sql에서 해당 id에 맞는 열을 삭제해주면된다.
    //삭제해주고 삭제됬다고 메세지 띄우고 원래 자리로 돌아가게해주면됨
}
function number(num){
    num=Number(num);
    if(num<=1){
        console.log("not prime");
    } else if(num==2 || num==3){
        console.log("not prime");
    } else if(num%2==0 || num%3==0){
        console.log("not prime");
    }else{
        console.log("prime");
    }
    
}
let num=Number(prompt("enter number"));
number(num);
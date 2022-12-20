String.prototype.trim = function() {
  var trimmed = this.replace(/^\s+|\s+$/g, '');
  return trimmed;
};

String.prototype.ltrim = function() {
  var trimmed = this.replace(/^\s+/g, '');
  return trimmed;
};

String.prototype.rtrim = function() {
  var trimmed = this.replace(/\s+$/g, '');
  return trimmed;
};

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  if(!tabcontent) {
    return;
  }
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  if(!tablinks) {
    return;
  }
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  // console.log(cityName);
  let contents = document.querySelectorAll(".tabcontent");
  for(const content of contents) {
    content.style.display="none";
  }
  console.log("tab-"+cityName);
  console.log(cityName);
  console.log("==>" + "tab-"+cityName);
  let a = document.getElementById(cityName);
  let b = document.getElementById("tab-"+cityName);
  if(a) {
    a.style.display = "block";
    document.getElementById("tab-"+cityName).className += " active";
  }
  else {
    document.getElementById("tab-"+cityName).style.display = "block";
  }
  // evt.currentTarget.className += " active";
}

window.addEventListener("load", function() {
  // let def = document.getElementById("defaultOpen");
  // if(def) {
  //   def.click();
  // }
});

function startPlaying(elm, planIndex, planTabID, planID, planFamily) {
  let select = elm.parentElement.querySelector("select");
  console.log(select);
  console.log(select.value);
  console.log(planIndex);
  console.log(planID);
  console.log(planFamily);



Swal.fire({
  title: 'شروع بازی',
  text: "آیا از شروع زمان "  +select.value +" مطمئن هستید؟",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'خیر',
  confirmButtonText: 'بله'
}).then((result) => {
  if (result.isConfirmed) {

    sendStartPlaying(planID, planIndex, planTabID, planFamily, select.value, select.selectedIndex);

  }
})


// let sure = confirm("آیا از شروغ زمان "  +select.value +" مطمئن هستید؟");
//   if(sure === true) {
//     sendStartPlaying(planID, planIndex, planTabID, planFamily, select.value, select.selectedIndex);
//   }
}

function sendStartPlaying(planID, planIndex, planTabID, planFamily, planDasteName, planDasteIndex) {
  sendRequest("api/start-playing.php", {
    planID: planID,
    planTabID: planTabID,
    planIndex: planIndex,
    planDasteName: planDasteName,
    planDasteIndex: planDasteIndex+1,
    planFamily: planFamily,
  }, function(res) {
    // alert(res);
    Swal.fire("شروع بازی", res);
  })
}

function sendRequest(link, params, callback) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
    //   console.log("output response: " + this.responseText);
      callback(this.responseText);
    }
  };
  xhttp.open("POST", link, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  let res_param = "";
  for(const key of Object.keys(params)) {
    res_param+=key + "=" + params[key]+"&"; 
  }
  res_param = res_param.rtrim();
//   console.log(link, res_param);
  xhttp.send(res_param);
}

function stopOrder(orderID) {
  sendRequest("api/stop-order.php", {
    orderID: orderID,
  }, function(res) {
    // alert(res);
    Swal.fire("متوقف کردن سفارش", res);
  })
}

function setPrePayment(elm, planID, planTabID, planIndex, planFamily) {
  let field = elm.parentElement.querySelector("input");
  console.log("pre-payment price is: " + field.value);
  sendRequest("api/set-pre-payment.php", {
    price: field.value,
    planID: planID,
    planTabID: planTabID,
    planIndex: planIndex,
    planFamily: planFamily,
  }, function(res) {
    // alert(res);
    Swal.fire("ثبت پیش پرداخت", res);
  })
}

function startTransfer(elm, planIndex, planTabID, planID, planFamily) {
  let daste = elm.parentElement.querySelector("select[name=daste]");
  let plan = elm.parentElement.querySelector("select[name=plan]");

  let planPart = plan.value.split("_");
  if(!planPart || planPart.length < 2) {
    return;
  }

  console.log(plan);
  console.log(plan.value);

  console.log(daste);
  console.log(daste.value);

  console.log(planIndex);
  console.log(planID);
  console.log(planFamily);

Swal.fire({
  title: 'انتقال بازی',
  text: "آیا از انتقال مطمئن هستید؟",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'خیر',
  confirmButtonText: 'بله'
}).then((result) => {
  if (result.isConfirmed) {

    sendStartTransfer(planID, planIndex, planTabID, planFamily, daste.value, daste.selectedIndex, planPart[0], planPart[1]);

  }
})

//   let sure = confirm("آیا از انتقال مطمئن هستید؟");
//   if(sure === true) {
//     sendStartTransfer(planID, planIndex, planTabID, planFamily, daste.value, daste.selectedIndex, planPart[0], planPart[1]);
//   }
}

function sendStartTransfer(planID, planIndex, planTabID, planFamily, planDasteName, planDasteIndex, toPlanID, toPlanIndex) {
  sendRequest("api/start-transfer.php", {
    planID: planID,
    planIndex: planIndex,
    planTabID: planTabID,
    planFamily: planFamily,
    planDasteName: planDasteName,
    planDasteIndex: planDasteIndex+1,
    toPlanID: toPlanID,
    toPlanIndex: toPlanIndex,
  }, function(res) {
    // alert(res);
    Swal.fire("انتقال سفارش", res);
  })
}

function addFood(elm, planIndex, planTabID, planID, planFamily) {
  let food = elm.parentElement.querySelector("select[name=food]");
  let count = elm.parentElement.querySelector("select[name=food_count]");
  console.log(food.value);
  console.log(count.value);
  console.log(planID);
  console.log(planIndex);


Swal.fire({
  title: 'اضافه کردن بوفه',
  text: "آیا از اضافه کردن "  +count.value + " عدد به سبد مطمئن هستید؟",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'خیر',
  confirmButtonText: 'بله'
}).then((result) => {
  if (result.isConfirmed) {

    sendAddFood(planID, planIndex, planTabID, food.value, count.value);

  }
})


//   let sure = confirm("آیا از اضافه کردن "  +count.value + " عدد به سبد مطمئن هستید؟");
//   if(sure === true) {
//     sendAddFood(planID, planIndex, planTabID, food.value, count.value);
//   }
}

function sendAddFood(planID, planIndex, planTabID, food, count) {
  sendRequest("api/add-order-food.php", {
    planID: planID,
    planIndex: planIndex,
    planTabID: planTabID,
    food: food,
    count: count,
  }, function(res) {
    // alert(res);
    Swal.fire("اضافه کردن از بوفه", res);
  })
}

function openChangeTime(type, elm, orderID, default_value) {
//   let editBox = elm.parentElement.querySelector("#edit-manualy");
//   editBox.style.display = "block";
    if(type === 1) {
        // let min = prompt("تعداد دقیقه تا کنون:", default_value);
        Swal.fire(
        {
            title: "تعداد دقیقه تا کنون:",
          input: 'text',
          inputLabel: 'تعداد دقیقه',
          inputValue: default_value,
        })
        .then((min) => {
        //   Swal.fire(`You typed: ${min}`);

            min = min.value;
            if(min === undefined || min === null || min == "") {
                return;
            }
            else {
                // alert(min);
                min = parseInt(min);
                // alert(min);
                
                if(min < 0) {
                    min = 0;
                }
        
                let field = elm.parentElement.querySelector("input[name=time]");
                field.value = min;
                
                /////////////////////////
                
                // let has_timer = confirm("آیا زمان معکوس اعمال شود؟");
                // console.log(has_timer);

Swal.fire({
  title: 'تایمر',
  text: "آیا زمان معکوس اعمال شود؟",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'خیر',
  confirmButtonText: 'بله'
}).then((result) => {

                field = elm.parentElement.querySelector("input[name=timer]");

  if (result.isConfirmed) {

                field.value = 1;
  }
  else {
                      field.value = 0;

  }
                changeTime(elm, orderID);
})


                // field = elm.parentElement.querySelector("input[name=timer]");
                // field.value = (has_timer === true ? 1 : 0);
                // changeTime(elm, orderID);

                
            }

        });



    }
    else {
        // let daste = prompt("تعداد دسته:", default_value);
        Swal.fire(
        {
            title:"تعداد دسته:",
          input: 'text',
          inputLabel: 'تعداد دسته',
          inputValue: default_value,
        })
        .then((daste) => {
            daste = daste.value;
            if(daste === undefined || daste === null || daste == "") {
                return;
            }
            else {
                // alert(daste);
                daste = parseInt(daste);
                // alert(daste);
                
                if(daste < 1) {
                    daste=1;
                }
                else if(daste > 4) {
                    daste = 4;
                }
                
                let field = elm.parentElement.querySelector("input[name=daste]");
                field.value = daste;
                changeTime(elm, orderID);
            }
        });

    }
}

function changeTime(elm, orderID) {
  let editBox = elm.parentElement;
  editBox.style.display = "none";

  let time = elm.parentElement.querySelector("input[name=time]");
  console.log(time);
  let daste = elm.parentElement.querySelector("input[name=daste]")
  console.log(daste);
  let has_timer = elm.parentElement.querySelector("input[name=timer]")
  console.log(has_timer);
  // console.log(time.value);
  sendRequest("api/change-time-manually.php", {
    orderID: orderID,
    time: time.value,
    timer: has_timer.value,
    // daste: daste.options[daste.selectedIndex].value,
    daste: daste.value,
  }, function(res) {
    // alert(res);
    Swal.fire("تنظیم زمان دستی", res);
  })
}


/* LIVE VARIABLES */
var LIVE = "";
var table_list;
var systems;

/* LIVE */
let ALERT_TIMER_CACHE = [];
function live_table(obj) {
    let html = ``
    let i=1;
    for(let plan of LIVE.table) {
        let box = ``;
  if(i !== 3) {
      box = `<div class="rows-${plan.count}">`;
  }
        for(let item of plan.items) {

    
            if(item.timer === 1 && item.timer_left <= 1 && item.timer_left > 0) {
                let timer_key = item.id+" "+item.family;
                if(!ALERT_TIMER_CACHE[timer_key]) {
                    // alert(`وقت سیستم ${item.id} ${item.family}، یک دقیقه دیگر به پایان می رسد.`);
                    Swal.fire("تایمر", `وقت سیستم ${item.id} ${item.family}، یک دقیقه دیگر به پایان می رسد.`);
                    ALERT_TIMER_CACHE[timer_key] = true;
                }
            }
    
            let block = `<div id="btn-system-${item.id}" class="col ${item.color}" onclick="openCity(event, 'system-${item.id}')">
          ${item.id}
          &nbsp;
          ${item.family}
      <hr>
      <b>قیمت: </b>
      <br>
      <label>
          ${item.price}
      </label>
      <hr>
      <b>زمان: </b>
      <br>
      <label>
          ${
              item.timer === 1 ? item.timer_left : item.time
          }
      </label>
      <hr>
      <b>دسته: </b>
      <br>
      <label>
          ${item.daste}
      </label>
    </div>`
            box += block
        }
  if(i !== 2) {
      box += `</div>`;
  }
        html += box;
  i++;
    }
    table_list.innerHTML = html
}

function live_sections(obj) {
    let i = 1;
    for(let section of LIVE.section) {
        let block = systems[i-1];
        console.log(block);
        
        let price = block.querySelector(".total-price");
        price.innerText = section.price;
        console.log(price);
        console.log(section.price);

        let payment = block.querySelector(".total-price-to-payment");
        payment.innerText = section.price_payment;
        console.log(payment);
        console.log(section.price_payment);

        let html = ``;
        for(let item of section.table) {
            let code = `<tr>
                <td>
                    ${item.daste}
                </td>
                <td>
                    ${item.date}
                </td>
                <td>
                    ${item.time}
                    ${
                        (item.timer === 1) ? "(" + item.timer_left + " دقیقه = "+ item.timer_left_price + " تومان)" : ""
                    }
                    <input name="daste" type="hidden" value="${item.daste}">
                    <input name="time" type="hidden" value="${item.time_min}">
                    <input name="timer" type="hidden" value="${item.timer}">
                    <button onclick="openChangeTime(1, this, ${item.id}, ${item.time_min});">تغییر زمان</button>
                    <button onclick="openChangeTime(2, this, ${item.id}, ${item.daste});">تغییر دسته</button>
                </td>
                <td>
                    ${item.price} تومان
                </td>
                <td>
                    <button onclick="stopOrder(${item.id})">متوقف کردن</button>
                </td>
            </tr>`
            html += code
        }
        let table = block.querySelector(".table_content_rows");
        table.innerHTML = html;

        i++;
    }
}

function live() {
    sendRequest("api/live/home-table.php", {}, function(res) {
        // console.log("response", res);
        if(res === undefined || res === "") {
            return;
        }
        let obj = JSON.parse(res);
        LIVE = obj;

        live_table(obj);
        live_sections(obj);
    });
}

window.addEventListener('load', function() {
    table_list = document.querySelector("#table-list");
    systems = document.querySelectorAll(".tabcontent-system");
    live();
    setInterval(live, 5000);
});

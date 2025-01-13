document.addEventListener("DOMContentLoaded", function () {
    // ======== Learn More 與 收合邏輯 ========
    const learnMoreButton = document.getElementById("learnMoreBtn");
    const collapseButton = document.getElementById("collapseBtn");
    const extraCardsSection = document.getElementById("extraCards");
    const collapseSection = document.querySelector(".collapse_section");

    // 點擊 Learn More 展開卡片並顯示收合按鈕
    learnMoreButton.addEventListener("click", function (event) {
        event.preventDefault(); // 防止滾回頁面頂端
        extraCardsSection.classList.add("expanded");
        extraCardsSection.style.maxHeight = extraCardsSection.scrollHeight + "px"; // 自動調整高度
        learnMoreButton.classList.add("hidden"); // 隱藏 Learn More 按鈕
        collapseSection.classList.remove("hidden"); // 顯示收合按鈕
    });

    // 點擊 收合按鈕 收回卡片並隱藏收合按鈕
    collapseButton.addEventListener("click", function (event) {
        event.preventDefault(); // 防止滾回頁面頂端
        extraCardsSection.classList.remove("expanded");
        extraCardsSection.style.maxHeight = "0px";
        learnMoreButton.classList.remove("hidden"); // 再次顯示 Learn More 按鈕
        collapseSection.classList.add("hidden"); // 隱藏收合按鈕
    });

    // ======== 完成 +1 功能邏輯 ========
    const buttons = document.querySelectorAll(".btn-Ac_done_btn");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const card = button.closest(".AcB_card");
            const countElement = card.querySelector(".action-count"); // 取得數字元素
            let currentCount = parseInt(countElement.textContent); // 轉換數字

            // 確保每張卡片只能點擊一次
            if (!button.disabled) {
                currentCount += 1;
                countElement.textContent = currentCount; // 更新數字
                button.textContent = "已完成!";
                button.disabled = true; // 禁用按鈕
                button.classList.add("disabled"); // 添加CSS樣式
            }
        });
    });
});


//    document.addEventListener("DOMContentLoaded", function () {
//     // ======== Learn More 與 收合邏輯 ========
//     const learnMoreButton = document.getElementById("learnMoreBtn");
//     const collapseButton = document.getElementById("collapseBtn");
//     const extraCardsSection = document.getElementById("extraCards");
//     const collapseSection = document.querySelector(".collapse_section");

//     learnMoreButton.addEventListener("click", function (event) {
//         event.preventDefault();
//         extraCardsSection.classList.add("expanded");
//         extraCardsSection.style.maxHeight = extraCardsSection.scrollHeight + "px";
//         learnMoreButton.classList.add("hidden");
//         collapseSection.classList.remove("hidden");
//     });

//     collapseButton.addEventListener("click", function (event) {
//         event.preventDefault();
//         extraCardsSection.classList.remove("expanded");
//         extraCardsSection.style.maxHeight = "0px";
//         learnMoreButton.classList.remove("hidden");
//         collapseSection.classList.add("hidden");
//     });

//     // ======== 完成 +1 功能邏輯 (針對每個卡片的獨立控制) ========
//     const buttons = document.querySelectorAll(".btn-Ac_done_btn");

//     buttons.forEach(button => {
//         button.addEventListener("click", function () {
//             const card = button.closest(".AcB_card");
//             const countElement = card.querySelector(".action-count");
//             let currentCount = parseInt(countElement.textContent);

//             if (!button.disabled) {
//                 currentCount += 1;
//                 countElement.textContent = currentCount;
//                 button.textContent = "感謝你的響應！";
//                 button.disabled = true;
//                 button.classList.add("disabled");

//                 // ======== 修改這裡：選擇正確的 popup 與 animation 元素 ========
                
                let popButton = document.querySelector('.btn-Ac_done_btn');
                let popup = document.querySelector('.popup');

                popButton.addEventListener('click', function () {
                    // alert('ttt');
                    
                    popup.classList.add("Ac_active");
                    animate()

                })
                setTimeout(() => {
                    popup.classList.remove("Ac_active");
                }, 7000);

                
// //                 const popup = card.querySelector(".popup"); 
// //                 const animationElement = card.querySelector("svg"); 

// //                 // ======== 防止找不到元素的錯誤處理 ========
// //                 if (!popup || !animationElement) {
// //                     console.error("Popup or Animation Element not found");
// //                     return;
// //                 }

// //                 popup.classList.add("active");
// // s
// //                 // GSAP 動畫
// //                 gsap.fromTo(animationElement, 
// //                     { scale: 0, opacity: 0 }, 
// //                     { scale: 1, opacity: 1, duration: 2, ease: "elastic.out(1, 0.3)" }
// //                 );

// //                 gsap.to(animationElement, { opacity: 0, scale: 0, duration: 1, delay: 3 });
// //                 setTimeout(() => {
// //                     popup.classList.remove("active");
// //                 }, 4000);
//             }
//         });
//     });
// });

function setup() {
  TweenMax.set("#shadow", {
    scale: 0,
    transformOrigin: "15px 8px"
  });
  TweenMax.set("#tree", {
    scale: 0,
    transformOrigin: "154px bottom"
  });
  TweenMax.set("#leaf-rb", {
    scale: 0,
    rotation: "-60cw",
    y: -15,
    transformOrigin: "left bottom"
  });
  TweenMax.set("#leaf-rm", {
    scale: 0,
    rotation: "-50cw",
    y: 30,
    transformOrigin: "left bottom"
  });
  TweenMax.set("#leaf-lb", {
    scale: 0,
    rotation: "60cw",
    y: -80,
    transformOrigin: "right bottom"
  });
  TweenMax.set("#leaf-lm", {
    scale: 0,
    rotation: "40cw",
    y: -90,
    transformOrigin: "right bottom"
  });

  TweenMax.set("#leaf-top", {
    scale: 0,
    transformOrigin: "center bottom"
  });

  TweenMax.set("#leaf-rb g", {
    scale: 0,
    transformOrigin: "left 60px"
  });
  TweenMax.set("#leaf-rm g", {
    scale: 0,
    transformOrigin: "22px 140px"
  });
  TweenMax.set("#leaf-lb g", {
    scale: 0,
    transformOrigin: "right 56px"
  });
  TweenMax.set("#leaf-lm g", {
    scale: 0,
    transformOrigin: "106px bottom"
  });
}

// // // This should be called on document.load
function animate() {
    console.log('111');
    
  var tl = new TimelineMax({
    delay: 0.42,
    repeat: 1,
    repeatDelay: 2,
    yoyo: true
  });

  tl.to(
    "#shadow",
    2,
    {
      scale: 1
    },
    0
  )
    .to(
      "#tree",
      2,
      {
        scale: 1
      },
      0
    )
    .to(
      "#leaf-rb",
      2,
      {
        scale: 1,
        rotation: "0cw",
        y: 0,
        delay: 0.35
      },
      0
    )
    .to(
      "#leaf-rm",
      2,
      {
        scale: 1,
        rotation: "0cw",
        y: 0,
        delay: 0.35
      },
      0
    )
    .to(
      "#leaf-lb",
      2,
      {
        scale: 1,
        rotation: "0cw",
        y: 0,
        delay: 0.35
      },
      0
    )
    .to(
      "#leaf-lm",
      2,
      {
        scale: 1,
        rotation: "0cw",
        y: 0,
        delay: 0.35
      },
      0
    )
    .to(
      "#leaf-top",
      2.5,
      {
        scale: 1,
        delay: 0.35
      },
      0
    )
    .to(
      "#leaf-lb g",
      2.25,
      {
        scale: 1,
        delay: 0.5
      },
      0
    )
    .to(
      "#leaf-lm g",
      2.25,
      {
        scale: 1,
        delay: 0.6
      },
      0
    )
    .to(
      "#leaf-rb g",
      2.25,
      {
        scale: 1,
        delay: 0.5
      },
      0
    )
    .to(
      "#leaf-rm g",
      2.25,
      {
        scale: 1,
        delay: 0.6
      },
      0
    );

  return tl;
}

// function stopAndReset() {
//   TweenMax.killAll(false, true, false);
//   TweenMax.set("#tree", { clearProps: "all" });
//   TweenMax.set("#shadow", { clearProps: "all" });
//   TweenMax.set("#leaf-top", { clearProps: "all" });
//   TweenMax.set("#leaf-rb", { clearProps: "all" });
//   TweenMax.set("#leaf-rm", { clearProps: "all" });
//   TweenMax.set("#leaf-lb", { clearProps: "all" });
//   TweenMax.set("#leaf-lm", { clearProps: "all" });
//   TweenMax.set("#leaf-top", { clearProps: "all" });
//   TweenMax.set("#leaf-rb g", { clearProps: "all" });
//   TweenMax.set("#leaf-rm g", { clearProps: "all" });
//   TweenMax.set("#leaf-lb g", { clearProps: "all" });
//   TweenMax.set("#leaf-lm g", { clearProps: "all" });

// // function playAgain() {
// //   stopAndReset();
// //   setup();
// //   animate();
// }

//  stopAndReset();
 setup();
//  window.onload = animate;
<template>
  <div class="gameWrapper">
    <MainHeader></MainHeader>
    <div id="gameContainer" ref="gameContainer"></div>
  </div>
</template>

<script>
import { watch, onMounted, ref, onUnmounted } from 'vue';
import { useRoute } from "vue-router";
import Phaser from 'phaser';
import MainHeader from "@/components/layout/MainHeader.vue";
import gsap from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollToPlugin); // ✅ 註冊 ScrollToPlugin

export default {
  comments:{
    MainHeader,
  },
  setup() {
    const route = useRoute();

    const updateHeaderPosition = () => {
      const header = document.querySelector("header");
      if (!header) return;

      if (route.path === "/city") {
        header.style.position = "static";
        header.style.top = "0";
      } else {
        header.style.position = "fixed";
        header.style.top = "0";
      }
    };

    watch(
      () => route.path,
      () => {
        updateHeaderPosition();
      },
      { immediate: true }
    );


    // ✅ Vue 3 的 `ref`，用來綁定遊戲的 DOM 容器
    const gameContainer = ref(null);

    // ✅ 使用 Vue 3 的 `ref` 來確保 UI 可以即時更新
    const score = ref(0);

    // ✅ 遊戲內部變數
    var player, ground, cursors, trashS, bombs, platformsWhite;
    var gameOver = false; // ✅ 用來檢查遊戲是否結束

    let scrollAnimation = null; // ✅ 儲存 GSAP 動畫



    onMounted(() => {
      // 監聽 DOM 變化，確保 `header` 被渲染
      const observer = new MutationObserver(() => {
      updateHeaderPosition();
      });

      observer.observe(document.body, { childList: true, subtree: true });

      // ✅ **進入頁面時立即檢查**
      updateHeaderPosition();

      if (gameContainer.value) {
        gameContainer.value.innerHTML = ""; // 清除舊遊戲畫面
      }

      // ✅ Phaser 遊戲設定
      const config = {
        type: Phaser.AUTO, // ✅ 自動選擇 WebGL 或 Canvas
        width: 1280, // ✅ 遊戲畫面的寬度
        height: 630, // ✅ 遊戲畫面的高度
        physics: {
          default: 'arcade', // ✅ 使用 Arcade 物理系統
          arcade: {
            gravity: { y: 240 }, // ✅ 設定重力，讓角色能夠跳躍
            debug: false, // ✅ 關閉偵錯模式
          },
        },
        parent: gameContainer.value, // ✅ Phaser 遊戲將綁定 Vue 元素
        scene: {
          preload: preload, // ✅ 載入資源
          create: create,   // ✅ 創建遊戲物件
          update: update    // ✅ 更新遊戲邏輯
        },
      };

      // ✅ 創建 Phaser 遊戲實例
      const game = new Phaser.Game(config);
      game.sound.mute = true; // ✅ 關閉遊戲音效

      // **📌 預載入遊戲素材**
      function preload() {
        // 城市背景
        this.load.image('city', new URL('@/assets/images/city/city_background_remake.png', import.meta.url).href);
        // 城市地基
        this.load.image('ground', new URL('@/assets/images/city/city_ground.png', import.meta.url).href);
        // 平台
        this.load.image('platform_white', new URL('@/assets/images/city/block.svg', import.meta.url).href);
        // 傳送門
        this.load.image('outdoor', new URL('@/assets/images/city/outdoor.png', import.meta.url).href);
        // 垃圾
        this.load.image('trash', new URL('@/assets/images/city/trash3.png', import.meta.url).href);
        // 炸彈
        this.load.image('bomb', new URL('@/assets/images/city/attack.svg', import.meta.url).href);
        // 鳥: 飛行動畫
        this.load.spritesheet('birdFly', new URL('@/assets/images/city/animals/birds/bird_fly/bird_fly.png', import.meta.url).href, {
            frameWidth: 80,
            frameHeight: 80,
        });
        // 鳥: 覓食動畫
        this.load.spritesheet('birdEat', new URL('@/assets/images/city/animals/birds/bird_eat/bird_eat.png', import.meta.url).href, {
          frameWidth: 75,  // ✅ 設定每個影格的寬度
          frameHeight: 75, // ✅ 設定影格高度
          endFrame: 5,     // ✅ 這張雪碧圖共有 6 幀（索引 0~5）
        });
        // 貓咪: 隨機走動
        this.load.spritesheet('cat_black', new URL('@/assets/images/city/animals/cats/cat_black-32x48.png', import.meta.url).href, {
        frameWidth: 32,
        frameHeight: 48,
        });

        this.load.spritesheet('cat_white', new URL('@/assets/images/city/animals/cats/cat_white-32x48.png', import.meta.url).href, {
            frameWidth: 32,
            frameHeight: 48,
        });

        this.load.spritesheet('cat_brown', new URL('@/assets/images/city/animals/cats/cat_brown-32x48.png', import.meta.url).href, {
            frameWidth: 32,
            frameHeight: 48,
        });

        this.load.spritesheet('cat_orange', new URL('@/assets/images/city/animals/cats/cat_orange-32x48.png', import.meta.url).href, {
            frameWidth: 32,
            frameHeight: 48,
        });

        // console.log("✅ 已載入所有貓咪圖片！");


        // 小寵物: 獅子
        this.load.spritesheet('lion', new URL('@/assets/images/city/Character/lion/lionWalk.png', import.meta.url).href, {
          frameWidth: 700,
          frameHeight: 700,
        });
        this.load.spritesheet('lionIdle', new URL('@/assets/images/city/Character/lion/lionIdle.png', import.meta.url).href, {
            frameWidth: 700,
            frameHeight: 700,
        });
        this.load.image('lionDie', new URL('@/assets/images/city/Character/lion/Die_009.png', import.meta.url).href);



        // 小寵物: 狐狸
        // this.load.spritesheet('foxy', new URL('@/assets/images/city/Character/Character_Sprites/fox_walk.png', import.meta.url).href, {
        //   frameWidth: 700,
        //   frameHeight: 700,
        // });
        // this.load.spritesheet('foxyIdle', new URL('@/assets/images/city/Character/Character_Sprites/fox_Idle.png', import.meta.url).href, {
        //     frameWidth: 700,
        //     frameHeight: 700,
        // });
        // this.load.image('foxDie', new URL('@/assets/images/city/Character/Character_Sprites/fox_die.png', import.meta.url).href);



      }


      let player;

      // **📌 遊戲初始化**
      function create() {

        if (!this.input) {
          console.error("🚨 `this.input` 尚未初始化，鍵盤監聽失敗！");
          return;
        }

        // ✅ 選擇隨機角色
        const characterKeys = ['lion', 'fox'];
        const selectedCharacterKey = Phaser.Utils.Array.GetRandom(characterKeys);

        // ✅ 創建角色
        player = this.physics.add.sprite(400, 300, selectedCharacterKey);
        player.setCollideWorldBounds(true); // 限制在畫面內




        this.physics.resume();
        // console.log("✅ 物理引擎已啟動:", !this.physics.world.isPaused);
        gameOver = false; // ✅ 遊戲重新開始時重置 `gameOver`

        if (!cursors) {
            console.error("⛔ `cursors` 尚未初始化，重新綁定鍵盤事件！");
            cursors = this.input.keyboard.createCursorKeys();
          }

          // console.log("⌨️ `this.input.keyboard.enabled` 狀態:", this.input.keyboard.enabled);



        // ✅ 確保動畫不重複創建
        if (this.anims.exists('left')) {
          this.anims.remove('left');
        }
        if (this.anims.exists('turn')) {
          this.anims.remove('turn');
        }
        if (this.anims.exists('right')) {
          this.anims.remove('right');
        }

        // ✅ 讓 Phaser 不攔截滑鼠滾輪事件
        this.input.mouse.disableContextMenu(); // 防止右鍵菜單
        this.input.manager.enabled = true; // 停用 Phaser 內建輸入管理器，避免影響滾動
        this.input.mouse.enabled = true;  // ✅ 確保滑鼠滾動可用
        this.input.keyboard.enabled = true; // ✅ 確保鍵盤可用
        this.input.setTopOnly(false); // ✅ 確保點擊不會被 Phaser 遮擋

        // ✅ **確保只創建一次彈窗**
        if (!this.popupBackground) {
          // ✅ **半透明遮罩**
          this.overlay = this.add.rectangle(640, 315, 1280, 630, 0x000000, 0.7);
          this.overlay.setDepth(90); // ✅ 確保遮罩在最上層

          // ✅ **彈窗背景**
          this.popupBackground = this.add.graphics();
          this.popupBackground.fillStyle(0xe6eccc, 1); // ✅ **背景顏色**
          this.popupBackground.fillRoundedRect(450, 200, 380, 250, 10); // ✅ **圓角 (10px)**
          this.popupBackground.lineStyle(2, 0xd0ad44); // ✅ **邊框**
          this.popupBackground.strokeRoundedRect(450, 200, 380, 250, 10); // ✅ **繪製邊框**
          this.popupBackground.setDepth(95); // ✅ **確保背景不會被蓋住**

          // ✅ **遊戲規則文字**
          this.instructions = this.add.text(
            640, 290,
            "遊戲規則：\n- 使用方向鍵左右移動角色\n- 按 ↑ 鍵跳躍\n- 收集垃圾來獲取分數\n- 小心炸彈，碰到炸彈遊戲結束！",
            {
              fontSize: "18px",
              FontFamily: 'DM Sans, Noto Sans',
              color: "#2e4e3f",
              align: "center",
              wordWrap: { width: 400 },
              padding: { top: 10, bottom: 5 }, // ✅ **增加內邊距**
              lineSpacing: 8, // ✅ **增加行距**
            }
          );
          this.instructions.setOrigin(0.5, 0.5);
          this.instructions.setDepth(96);

          // ✅ **開始按鈕**
          this.startButton = this.add.text(640, 400, "開始遊戲", {
            fontSize: "26px",
            backgroundColor: "#5b774a",
            color: "#e6eccc",
            FontFamily: 'DM Sans, Noto Sans',
            padding: { x: 20, y: 10 },
          })
          .setOrigin(0.5)
          .setInteractive()
          .setDepth(96);

          // 🎯 **點擊按鈕後開始遊戲**
          this.startButton.on("pointerdown", () => {
            // console.log("✅ 遊戲開始！");

            // ✅ **防止多次點擊**
            this.startButton.disableInteractive();

            // ✅ **確保所有 UI 元素已刪除**
            if (this.overlay) {
              // console.log("🔄 移除遮罩");
              this.overlay.destroy();
              this.overlay = null;
            }

            if (this.popupBackground) {
              // console.log("🔄 移除彈窗背景");
              this.popupBackground.destroy();
              this.popupBackground = null;
            }

            if (this.instructions) {
              // console.log("🔄 移除遊戲說明");
              this.instructions.destroy();
              this.instructions = null;
            }

            if (this.startButton) {
              // console.log("🔄 移除開始按鈕");
              this.startButton.destroy();
              this.startButton = null;
            }

            // console.log("🎯 所有彈窗元素已成功刪除！");
          });
        }


        // ✅ **恢復 Phaser 的輸入系統**
        this.input.setTopOnly(false);
        this.input.mouse.enabled = true; // ✅ 確保滑鼠輸入可用
        this.input.keyboard.enabled = true; // ✅ 確保鍵盤輸入可用

        // ✅ **確保遊戲先暫停，等玩家點擊「開始遊戲」後才運行**
        this.physics.pause();

        // ✅ **重新啟動遊戲物理引擎**
        this.physics.resume();



        // ✅ 地面（靜態）
        // ground = this.physics.add.static
        // this.add.image(640, 615, 'ground').setScale(.7);
        ground = this.physics.add.staticGroup();
        ground.create(640, 665, 'ground').setScale(.7).refreshBody();


        // ✅ 添加背景
        this.add.image(640, 315, 'city').setScale(0.7);

        // ✅ 建立白色平台（靜態）
        platformsWhite = this.physics.add.staticGroup();
        let p1 = platformsWhite.create(425, 350, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p1.setSize(80, 20).refreshBody(); // 設定碰撞範圍

        let p2 = platformsWhite.create(120, 218, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p2.setSize(80, 20).refreshBody();

        let p3 = platformsWhite.create(120, 425, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p3.setSize(80, 20).refreshBody();

        let p4 = platformsWhite.create(1110, 450, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p4.setSize(80, 20).refreshBody();

        let p5 = platformsWhite.create(975, 200, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p5.setSize(80, 20).refreshBody();

        let p6 = platformsWhite.create(1300, 255, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p6.setSize(80, 20).refreshBody();

        let p7 = platformsWhite.create(565, 150, 'platform_white').setScale(0.11, 0.2).refreshBody();
        p7.setSize(80, 20).refreshBody();






        // ✅ **定義鳥的飛行動畫**
        this.anims.create({
          key: 'birdFly',
          frames: this.anims.generateFrameNumbers('birdFly', { start: 0, end: 1 }), // ✅ 根據雪碧圖有多少幀調整
          frameRate: 5, // ✅ 設定動畫速度（可以調快點讓動作更流暢）
          repeat: -1, // ✅ 無限循環播放
        });

        // ✅ **建立一個 function 來創建鳥**
        function createBird(startX, startY, scale, speed) {
          const bird = this.add.sprite(startX, startY, 'birdFly').play('birdFly');
          bird.setScale(scale); // ✅ 設定鳥的大小
          bird.setFlipX(false); // ✅ 初始時面向右邊

          function flyBird() {
            bird.x = startX; // ✅ 讓鳥從畫面左側開始
            bird.y = Phaser.Math.Between(50, 150); // ✅ 每次飛行都改變隨機高度
            bird.setFlipX(false); // ✅ 讓鳥朝右飛行

            this.tweens.add({
              targets: bird,
              x: -100, // ✅ 讓鳥飛到畫面右側外部
              duration: speed, // ✅ 設定飛行時間（可自行調整）
              ease: 'Linear',
              onComplete: () => flyBird.call(this), // ✅ **修正遞迴問題，確保 `this` 正確**
            });
          }

          // ✅ **讓鳥無限擺動，但只設定一次**
          this.tweens.add({
            targets: bird,
            y: `+=${Phaser.Math.Between(-30, 30)}`, // ✅ 讓鳥在目前位置的 ±30 範圍內擺動
            duration: 800, // ✅ 擺動的速度（可自行調整）
            yoyo: true, // ✅ 讓動畫來回擺動
            repeat: -1, // ✅ 無限次重複
            ease: 'Sine.easeInOut', // ✅ 讓擺動更平滑
          });

          // ✅ **啟動飛行動畫**
          flyBird.call(this);
        }

        // ✅ **創建兩隻鳥**
        createBird.call(this, 1400, 30, 0.6, 12000); // 第一隻鳥，速度 8 秒
        createBird.call(this, 1400, 20, 0.8, 11500); // 第二隻鳥，速度 10 秒

        // ✅ 創建鳥覓食動畫
        this.anims.create({
          key: 'birdEating',
          frames: this.anims.generateFrameNumbers('birdEat', { start: 0, end: 5 }), // ✅ 播放 6 幀動畫
          frameRate: 6, // ✅ 調整播放速度
          repeat: -1, // ✅ 無限重播
        });

        const birds = []; // ✅ 存放所有小鳥
        const birdGroupX = 700; // ✅ 小鳥聚集區域的起始 x 座標
        const birdGroupY = 550; // ✅ 小鳥的基準 y 座標（地面）

        for (let i = 0; i < 5; i++) {
          let x = birdGroupX + i * 17 + Phaser.Math.Between(-1, 1); // ✅ 水平間隔 40px，避免重疊
          let y = birdGroupY + Phaser.Math.Between(-10, 10); // ✅ 每隻鳥的 Y 座標略有不同

          let bird = this.add.sprite(x, y, 'birdEat').play('birdEating');
          bird.setScale(0.4); // ✅ 縮小尺寸
          bird.setDepth(9); // ✅ 確保不會被其他物件擋住
          bird.setOrigin(0.5, 1); // ✅ 讓小鳥的腳對齊地面

          // ✅ 隨機設定每隻鳥的動畫速度
          bird.anims.msPerFrame = Phaser.Math.Between(300, 500);

          // ✅ 讓每隻鳥有 50% 機率翻轉 X 軸，改變方向
          if (Phaser.Math.Between(0, 1) === 1) {
            bird.setFlipX(true);
          }

          birds.push(bird); // ✅ 存入陣列

          // ✅ **讓每隻鳥不定期改變方向**
          this.time.addEvent({
            delay: Phaser.Math.Between(3000, 7000), // ✅ 2~5 秒內隨機變更方向
            loop: true,
            callback: () => {
              bird.setFlipX(!bird.flipX); // ✅ 翻轉方向
            },
          });
        }

        const catTypes = ["cat_black", "cat_white", "cat_brown", "cat_orange"];
        let shuffledCats = [...catTypes]; // 複製一份原始陣列
        let catIndex = 0;

        // ✅ **檢查所有貓咪圖片是否已加載**
        catTypes.forEach((cat) => {
          if (!this.textures.exists(cat)) {
              console.warn(`⚠️ 貼圖 '${cat}' 尚未載入，跳過動畫創建！`);
              return;
          }

          this.anims.create({
              key: `${cat}_walk_left`,
              frames: this.anims.generateFrameNumbers(cat, { start: 9, end: 11 }),
              frameRate: 6,
              repeat: -1
          });

          this.anims.create({
              key: `${cat}_walk_right`,
              frames: this.anims.generateFrameNumbers(cat, { start: 3, end: 5 }),
              frameRate: 6,
              repeat: -1
          });

          // console.log(`✅ 成功創建動畫: ${cat}_walk_left / ${cat}_walk_right`);
        });

        // console.log("所有已載入的貼圖:", this.textures.list);

        // ✅ **洗牌函數 (讓每輪的貓咪出現次數相同)**
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]]; // 交換元素
            }
        }

        // ✅ **確保場景內的貓咪類型出現次數相等**
        function getNextCatType() {
            if (catIndex >= shuffledCats.length) {
                shuffleArray(shuffledCats); // 重新洗牌
                catIndex = 0; // 重置索引
            }
            return shuffledCats[catIndex++]; // 依序取得不同的貓咪
        }


        this.cats = []; // ✅ **確保 `this.cats` 陣列存在**

        function createMovingCat() {
          if (this.cats.length >= 4) return; // ✅ **場景內最多 4 隻貓咪**

          let y = 580; // 貓咪的固定地面高度
          let speed = Phaser.Math.Between(20, 40); // ✅ 降低移動速度
          let catType = getNextCatType(); // ✅ 取得下一隻貓咪的種類

          if (!catType) {
              console.error("❌ 錯誤：無法取得貓咪類型");
              return;
          }

          // **隨機決定從左邊進場還是從右邊進場**
          let fromLeft = Phaser.Math.Between(0, 1) === 0;
          let x = fromLeft ? -50 : 1330; // 左側外部（-50） 或 右側外部（1330）

          let cat = this.add.sprite(x, y, catType);
          cat.setScale(1.5);
          cat.setDepth(10);
          cat.catType = catType; // ✅ **儲存貓咪類型，確保移動時能正確存取動畫**

          if (fromLeft) {
              cat.anims.play(`${catType}_walk_right`, true); // 向右走
          } else {
              cat.anims.play(`${catType}_walk_left`, true); // 向左走
          }

          this.cats.push(cat); // ✅ 加入場景內的貓咪陣列

          // **讓貓從外部緩慢走進場景**
          this.tweens.add({
              targets: cat,
              x: Phaser.Math.Between(100, 1200), // ✅ 隨機停在場景內某個位置
              duration: Phaser.Math.Between(30000, 30000), // ✅ **進場時間調慢**
              ease: "Linear",
              onComplete: () => moveCat.call(this, cat) // ✅ **當移動結束後，開始隨機走動**
          });
        }



        function moveCat(cat) {
          if (!cat || !cat.catType) {
              console.error("❌ 錯誤：貓咪或貓咪類型未定義", cat);
              return;
          }

          let direction = Phaser.Math.Between(0, 1) === 0 ? "left" : "right"; // ✅ 隨機選擇方向
          let speed = Phaser.Math.Between(80, 120); // ✅ 調整移動速度
          let targetX = direction === "left" ? cat.x - Phaser.Math.Between(100, 200) : cat.x + Phaser.Math.Between(100, 200);

          // **確保不會超出畫面範圍**
          if (targetX < -100 || targetX > 1330) {
              removeCat.call(this, cat); // ✅ **貓走出場景則刪除**
              return;
          }

          if (direction === "left") {
              cat.anims.play(`${cat.catType}_walk_left`, true);
          } else {
              cat.anims.play(`${cat.catType}_walk_right`, true);
          }

          // **讓貓來回隨機走動**
          this.tweens.add({
              targets: cat,
              x: targetX,
              duration: Phaser.Math.Between(5000, 8000), // ✅ 讓移動更自然
              ease: "Linear",
              onComplete: () => {
                  // ✅ **隨機決定是否要停頓**
                  let shouldPause = Phaser.Math.Between(0, 1) === 0; // 50% 機率停頓
                  if (shouldPause) {
                      cat.anims.stop(); // ✅ 停止動畫

                      // ✅ **根據方向設定靜止幀**
                      if (direction === "left") {
                          cat.setFrame(10); // **停在左邊靜止幀**
                      } else {
                          cat.setFrame(4); // **停在右邊靜止幀**
                      }

                      setTimeout(() => {
                          moveCat.call(this, cat); // ✅ **停頓後再繼續移動**
                      }, Phaser.Math.Between(1000, 7000)); // ✅ **隨機停頓 2~5 秒**
                  } else {
                      moveCat.call(this, cat); // ✅ **立即繼續移動**
                  }
              }
          });
        }


        function removeCat(cat) {
          if (!cat) return;

          this.cats = this.cats.filter(c => c !== cat); // ✅ **從陣列中移除**
          if (cat.destroy) cat.destroy(); // ✅ **確保 `cat` 仍存在後才刪除**

          // **確保場景內最多 4 隻貓咪**
          setTimeout(() => {
              if (this.scene) createMovingCat.call(this);
          }, Phaser.Math.Between(5000, 10000)); // ✅ **2~5 秒後新增新的貓咪**
        }



      // ✅ **初始化 4 隻貓咪**
      for (let i = 0; i < 4; i++) {
        createMovingCat.call(this);
      }







        // ✅ 玩家角色
        // 獅子
        player = this.physics.add.sprite(100, 450, 'lion');
        player.setBounce(0.2); // ✅ 讓角色有彈性
        player.setScale(0.15); // ✅ 縮小角色到 30% 大小
        player.setDepth(50);
        player.body.setGravityY(8); // ✅ 確保角色受重力影響
        player.setCollideWorldBounds(true); // ✅ 角色不會掉出場外
        this.lionDie = this.add.image(player.x, player.y, 'lionDie');
        this.lionDie.setOrigin(0.7);
        this.lionDie.setDepth(50);
        this.lionDie.setScale(player.scaleX, player.scaleY); // ✅ **將圖片縮小 50%**
        this.lionDie.setVisible(false); // ✅ **預設隱藏**



        // ✅ 角色動畫設定
        this.anims.create({
          key: 'left',
          frames: this.anims.generateFrameNumbers('lion', { start: 0, end: 9 }),
          frameRate: 20,
          repeat: -1,
        });

        // 角色靜止動畫
        this.anims.create({
            key: 'idle', // ✅ 設定動畫名稱
            frames: this.anims.generateFrameNumbers('lionIdle', { start: 0, end: 9 }), // ✅ 設定幀數範圍
            frameRate: 6, // ✅ 設定動畫速度
            repeat: -1, // ✅ 無限循環
        });

        this.anims.create({
          key: 'right',
          frames: this.anims.generateFrameNumbers('lion', { start: 0, end: 9 }),
          frameRate: 20,
          repeat: -1,
        });


        // ✅ **建立傳送門**
        this.outdoor = this.physics.add.staticImage(623, 510, 'outdoor').setScale(0.3);
        this.nearPortal = false; // ✅ 追蹤玩家是否在傳送門範圍內

        // ✅ **調整碰撞範圍，讓它與圖片大小匹配**
        this.outdoor.setSize(this.outdoor.width * 0.3, this.outdoor.height * 0.4);
        this.nearPortal = false; // ✅ 確認玩家是否靠近傳送門
        this.confirmDialog = null;
        this.portalText = null; // ✅ 存放 "Enter" 文字

        this.outdoor.refreshBody();  // 確保碰撞體積更新
        this.outdoor.setSize(this.outdoor.displayWidth, this.outdoor.displayHeight); // ✅ 讓 `hitbox` 跟 `displaySize` 一樣

        // console.log("📢 正在監聽 overlap 事件...");
        // console.log("🔍 檢查傳送門物件：", this.outdoor);
        // console.log("🔍 檢查玩家物件：", player);
        // console.log(`📍 玩家座標: x=${player.x}, y=${player.y}`);
        // console.log(`📍 傳送門座標: x=${this.outdoor.x}, y=${this.outdoor.y}`);
        // console.log("🛑 是否相交？", Phaser.Geom.Intersects.RectangleToRectangle(player.getBounds(), this.outdoor.getBounds()));

        // ✅ **繪製圓角矩形背景**
        let textBg = this.add.graphics();
        textBg.fillStyle(0x545454, 0.6); // ✅ 半透明灰色背景
        textBg.fillRoundedRect(590, 505, 120, 40, 10); // ✅ (x, y, width, height, border-radius)
        textBg.setDepth(39); // ✅ 確保背景在文字下方

        // ✅ **讓 "按 Enter 進入" 提示始終顯示**
        this.portalText = this.add.text(623, 520, "Enter 進入", {
            fontSize: "22px",
            fill: "#fffff0",
            backgroundColor: "#545454",
            padding: { x: 10, y: 5 },
            align: "center"
        });
        this.portalText.setOrigin(0.5);
        this.portalText.setDepth(40);

        // ✅ **讓背景與文字對齊**
        textBg.x = this.portalText.x - textBg.width / 2;
        textBg.y = this.portalText.y - textBg.height / 2;

        // ✅ **縮放動畫**
        this.tweens.add({
            targets: this.portalText,
            scaleX: 0.9,
            scaleY: 1,
            duration: 2000, // ✅ 動畫時間
            yoyo: true, // ✅ 讓動畫來回縮放
            repeat: -1, // ✅ 無限循環
            ease: "Sine.easeInOut"
        });


        // ✅ **每一幀檢查玩家是否在傳送門範圍**
        this.checkPlayerInPortal = () => {
            let distance = Phaser.Math.Distance.Between(player.x, player.y, this.outdoor.x, this.outdoor.y);
            let portalRadius = 80; // ✅ 設定傳送門的範圍大小

            if (distance < portalRadius && !this.nearPortal) {
                this.nearPortal = true;
                // console.log("✅ 玩家進入傳送門範圍");
            } else if (distance >= portalRadius && this.nearPortal) {
                this.nearPortal = false;
                // console.log("❌ 玩家離開傳送門範圍");
            }
        };

        // ✅ **監聽 Enter 鍵，只有在範圍內才能觸發**
        this.input.keyboard.on("keydown-ENTER", () => {
            if (this.nearPortal) {
                // console.log("🛑 玩家按下 Enter，顯示傳送確認對話框");
                this.showConfirmDialog();
            } else {
                // console.log("⛔ 玩家不在傳送門範圍內，無法開啟對話框");
            }
        }, this);


        // ✅ **監聽 Enter 鍵，只有在範圍內才能觸發**
        this.input.keyboard.on("keydown-ENTER", () => {
            if (this.nearPortal) {
                // console.log("🛑 玩家按下 Enter，顯示傳送確認對話框");
                this.showConfirmDialog();
            } else {
                // console.log("⛔ 玩家不在傳送門範圍內，無法開啟對話框");
            }
        }, this);

        // ✅ **顯示確認對話框**
        this.showConfirmDialog = () => {
            // console.log("🛑 顯示傳送確認對話框");

            let dialogBox = this.add.graphics();
            dialogBox.fillStyle(0x000000, 0.7);
            dialogBox.fillRoundedRect(450, 200, 400, 200, 10);
            dialogBox.setDepth(100);

            let dialogText = this.add.text(500, 250, "是否要進入傳送門？", {
                fontSize: "24px",
                fill: "#ffffff",
                padding: { x: 10, y: 5 },
            }).setDepth(101);

            let leaveButton = this.add.text(500, 300, "✅ 確定離開", {
                fontSize: "22px",
                fill: "#00ff00",
                backgroundColor: "#222222",
                padding: { x: 10, y: 5 },
            }).setInteractive().setDepth(101);

            let stayButton = this.add.text(650, 300, "❌ 留在原地", {
                fontSize: "22px",
                fill: "#ff0000",
                backgroundColor: "#222222",
                padding: { x: 10, y: 5 },
            }).setInteractive().setDepth(101);

            leaveButton.on("pointerdown", () => {
                // console.log("✅ 傳送至新場景...");
                window.location.href = "https://tibamef2e.com/tid103/g2/game";  // 一碳究竟 創建寵物頁
            });

            stayButton.on("pointerdown", () => {
                // console.log("❌ 取消傳送，回到遊戲");
                dialogBox.destroy();
                dialogText.destroy();
                leaveButton.destroy();
                stayButton.destroy();
            });
        };



        if (!this.outdoor) {
          console.error("🚨 `this.outdoor` 尚未被正確建立！");
        } else {
          // console.log("✅ `this.outdoor` 已經建立成功");
        }



        // 顯示物件的實際尺寸 物件外框
        // this.physics.world.createDebugGraphic();

        // console.log("🎮 玩家 `hitbox` 尺寸：", player.body.width, player.body.height);













        // ✅ 建立鍵盤輸入
        cursors = this.input.keyboard.createCursorKeys();
        // console.log('偵測到cursors', cursors);


        // ✅ 設定碰撞
        this.physics.add.collider(player, ground);
        this.physics.add.collider(player, platformsWhite);

        // ✅ 先初始化炸彈群組
        bombs = this.physics.add.group({
          bounceX: 1, // ✅ 確保炸彈在 X 軸上也會反彈
          bounceY: 1, // ✅ 確保炸彈可以持續彈跳
          collideWorldBounds: true, // ✅ 防止炸彈飛出畫面
        });

        // ✅ **確保炸彈持續彈跳**
        this.physics.add.collider(bombs, ground, (bomb) => {
          bomb.setVelocityY(-Phaser.Math.Between(600, 600)); // ✅ 每次碰撞地面時，重新設定彈跳速度
        });

        // ✅ **炸彈與玩家的碰撞**
        this.physics.add.collider(player, bombs, hitBomb, null, this);

        // ✅ **垃圾群組**
        trashS = this.physics.add.group({
          key: 'trash',
          repeat: 10,
          setXY: { x: 100, y: 0, stepX: 100 },
        });

        // ✅ **讓垃圾有隨機彈跳 + 設定大小**
        trashS.children.iterate((child) => {
          child.setBounceY(Phaser.Math.FloatBetween(0.3, 0.5)); // 讓垃圾有隨機彈跳
          child.setScale(Phaser.Math.FloatBetween(0.07, 0.1)); // ✅ 調整大小
          child.setDepth(20); // ✅ **所有垃圾統一設為深度**
        });

        // ✅ **垃圾碰撞**
        this.physics.add.collider(trashS, ground);
        this.physics.add.collider(trashS, platformsWhite);
        this.physics.add.overlap(player, trashS, collectTrash, null, this);

        // this.physics.add.collider(bombs, ground, (bomb) => {
        //   bomb.setVelocityY(-Phaser.Math.Between(100, 200)); // ✅ **每次碰到地面時，讓炸彈彈跳**
        // });

        // ✅ 建立炸彈群組
        // bombs = this.physics.add.group();
        this.physics.add.collider(bombs, ground);
        // this.physics.add.collider(player, bombs, hitBomb, null, this);

        // ✅ 設定分數顯示
        const scoreText = this.add.text(40, 20, '總分: 0', { fontSize: '28px', fill: 'black', FontFamily: 'DM Sans, Noto Sans', padding: { x: 1, y: 5 }, });

        // 📌 **收集垃圾**
        function collectTrash(player, trash) {
          this.tweens.add({
            targets: trash,
            scaleX: 0,
            scaleY: 0,
            alpha: 0,
            duration: 500, // ✅ 讓垃圾縮小 & 消失
            onComplete: () => {
              trash.disableBody(true, true);

              // ✅ 當所有垃圾被收集時，重新生成垃圾並放置炸彈
              if (trashS.countActive(true) === 0) { // 確保垃圾真的被收集完
                trashS.children.iterate((child) => {
                  child.enableBody(true, Phaser.Math.Between(50, 1200), Phaser.Math.Between(50, 500), true, true);
                  child.setScale(Phaser.Math.FloatBetween(0.07, 0.1)); // ✅ 確保每次生成的垃圾大小不同
                  // child.setBounceY(Phaser.Math.FloatBetween(0.3, 0.6)); // ✅ 讓垃圾繼續有彈性
                  child.setAlpha(1); // ✅ 重新設回可見
                });


              // ✅ **新增一顆新的炸彈**
              const x = Phaser.Math.Between(100, 1180); // ✅ **確保炸彈生成在安全區域**
              const bomb = bombs.create(x, 16, 'bomb');

              bomb.setBounce(Phaser.Math.FloatBetween(0.8, 1)); // ✅ **確保炸彈保持彈跳**
              bomb.setCollideWorldBounds(true); // ✅ **讓炸彈與場景邊界碰撞**
              bomb.setVelocity(Phaser.Math.Between(-150, 150), -Phaser.Math.Between(100, 200)); // ✅ **確保炸彈往上拋**
              bomb.setScale(0.2);
              bomb.body.allowGravity = true; // ✅ **確保炸彈受重力影響**
              bomb.body.onWorldBounds = true; // ✅ **監聽邊界碰撞**

              // console.log(`💣 新炸彈生成！當前炸彈數量: ${bombs.countActive(true)}`);
              }
            }
          });

          score.value += 10; // ✅ Vue 的 `ref()` 更新分數
          scoreText.setText('總分: ' + score.value);
        }

        // 📌 **當玩家碰到炸彈，遊戲結束**
        function hitBomb(player, bomb) {
          this.physics.pause();
          player.setTint(0xff0000);
          player.anims.play('turn');
          gameOver = true;

          // console.log("遊戲結束，顯示 Restart 按鈕");

          // ✅ **確保不會重複創建「重新開始」按鈕**
          if (this.restartButton) {
            this.restartButton.destroy();
            // console.log("🔄 已移除舊的 Restart 按鈕");
          }

          // ✅ 按鈕背景
          const buttonWidth = 180;
          const buttonHeight = 60;
          const buttonX = 640 - buttonWidth / 2; // 居中對齊
          const buttonY = 350 - buttonHeight / 2;
          const borderRadius = 15; // ✅ 圓角半徑

          // ✅ 使用 graphics 繪製圓角按鈕背景
          this.restartButtonBg = this.add.graphics();
          this.restartButtonBg.fillStyle(0x5b774a, 1); // ✅ **背景顏色**
          this.restartButtonBg.fillRoundedRect(buttonX, buttonY, buttonWidth, buttonHeight, borderRadius);
          this.restartButtonBg.lineStyle(2, 0xd0ad44); // ✅ **邊框顏色**
          this.restartButtonBg.strokeRoundedRect(buttonX, buttonY, buttonWidth, buttonHeight, borderRadius);
          this.restartButtonBg.setDepth(96); // ✅ 確保背景在文字下方

          // ✅ 創建新的 Restart 按鈕
          this.restartButton = this.add.text(640, 350, '重新開始', {
            fontSize: '26px',
            color: '#e6eccc',
            fontFamily: 'DM Sans, Noto Sans'
          })
            .setOrigin(0.5)
            .setInteractive()
            .setDepth(96); // ✅ **確保在最上層**

          // console.log("✅ Restart 按鈕已創建");

          setTimeout(() => {
            if (this.restartButton) {
              this.restartButton.on("pointerdown", () => {
                // console.log("🎮 按下 Restart 按鈕，準備重新啟動遊戲");
                restartGame(this);
              });
            }
          }, 50);
        }

        // 📌 **重新開始遊戲**
        function restartGame(scene) {
          // console.log("重新開始遊戲");

          // ✅ 移除舊動畫，確保重新載入場景時不會有衝突
          scene.anims.remove('left');
          scene.anims.remove('turn');
          scene.anims.remove('right');

          // ✅ 先停止場景，確保所有物件被清除
          scene.scene.stop();
          scene.scene.start(); // ✅ 重新啟動場景

          // scene.scene.restart();
          score.value = 0; // ✅ 重置分數
          gameOver = false; // ✅ 確保 `gameOver` 變數重置

          // ✅ 確保 `restartButton` 不會累積
          if (scene.restartButton) {
            scene.restartButton.destroy();
            scene.restartButton = null;
          }
        }
      }



      // 📌 **更新函式**
      function update() {
        if (!cursors) {
        console.warn("⚠️ `cursors` 在 update() 內為 undefined，重新初始化！");
        cursors = this.input.keyboard.createCursorKeys();
    }

        if (!cursors) {
        cursors = this.input.keyboard.createCursorKeys(); // 確保 `cursors` 存在
        }


        // ✅ 確保 this.lionDie 存在，避免 `undefined` 錯誤
        if (!this.lionDie) return;

        if (cursors.down.isDown) {
        // ✅ **切換到趴下狀態**
        player.setVisible(false); // 隱藏站立角色
        this.lionDie.setPosition(player.x, player.y + 20); // ✅ 讓趴下的圖片對齊
        this.lionDie.setVisible(true); // 顯示趴下的圖片
        player.setVelocityX(0); // ✅ 趴下時不能移動

          // ✅ 根據 player 的方向來翻轉 lionDie
          if (player.flipX) {
              this.lionDie.setFlipX(true); // 若 player 朝左，趴下的圖也要朝左
          } else {
              this.lionDie.setFlipX(false); // 若 player 朝右，趴下的圖維持原樣
          }
        } else {
        // ✅ **恢復站立狀態**
        player.setVisible(true); // 顯示站立角色
        this.lionDie.setVisible(false); // 隱藏趴下圖片


          if (cursors.left.isDown) {
            // console.log("⬅️ 左鍵按下！");
            player.setVelocityX(-160);
            player.anims.play('left', true);
            player.flipX = true; // ✅ 將圖片反轉面向左邊
          } else if (cursors.right.isDown) {
            // console.log("➡️ 右鍵按下！");
            player.setVelocityX(160);
            player.anims.play('right', true);
            player.flipX = false; // ✅ 恢復正常方向
          } else {
            player.setVelocityX(0);
            player.anims.play('idle', true); // ✅ **播放靜止動畫**
          }

          if (cursors.up.isDown && player.body.touching.down) {
            player.setVelocityY(-320);
          }
        }

        // ✅ **在 `update()` 內持續偵測玩家是否進入或離開傳送門範圍**
        this.events.on("update", this.checkPlayerInPortal);
      }

      // 阻止方向鍵影響網頁滾動
      window.addEventListener("keydown", (event) => {
        if (["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].includes(event.key)) {
          event.preventDefault(); // 阻止預設行為（網頁滾動）
        }
      });

      const enableScroll = (event) => {
        if (event.target.closest(".phaser-container")) {
          return; // ✅ 避免 Phaser 內部攔截
        }

        event.stopPropagation(); // ✅ 確保 Phaser 不攔截事件
        event.preventDefault();  // ✅ 避免 Phaser 阻止滾動

        // ✅ 使用 GSAP 讓滾動更流暢
        scrollAnimation = gsap.to(window, {
          duration: 5, // ✅ 滾動時間（數值越大越平滑）
          ease: "power3.out", // ✅ 使用 GSAP 平滑效果
          scrollTo: {
            y: window.scrollY + event.deltaY * 5, // ✅ 讓滾動距離與滾輪速度相符
            autoKill: false, // ✅ 防止 GSAP 自動停止滾動
          },
        });
      };

      // ✅ 監聽滑鼠滾輪事件，讓網頁可以正常滾動
      window.addEventListener("wheel", enableScroll, { passive: false });

      onUnmounted(() => {
        window.removeEventListener("wheel", enableScroll);

        if (game) {
            game.destroy(true); // ✅ 清除遊戲，避免鍵盤失效
        }

        if (scrollAnimation) {
          scrollAnimation.kill(); // ✅ 停止 GSAP 動畫
        }
        gsap.globalTimeline.clear(); // ✅ 清除所有 GSAP 動畫

        window.removeEventListener("keydown", (event) => {
          if (["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].includes(event.key)) {
            event.preventDefault();
          }
        });

      });

    });


    return {
      gameContainer,
      score,
    };
  },
};

</script>

<style>
.game-wrapper {
  display: flex;
  flex-direction: column; /* ✅ 讓 Header 在上，Game 在下 */
  height: 100vh; /* ✅ 讓畫面滿版 */
}

#gameContainer {
  width: 100%;
  flex-grow: 1; /* ✅ 讓遊戲區塊佔據剩餘的空間 */
  height: calc(100vh - 80px); /* ✅ 讓遊戲畫面填滿剩餘空間 */
}
#gameContainer canvas {
 display: block;
 margin: auto;
}
</style>

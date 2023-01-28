var bt = document.getElementById('mybt');
bt.addEventListener('click' , (e)=> {
  var imagelink = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Tokyo_Sky_Tree_2012_%E2%85%A5.JPG',
  downloadSize = 8185374,
  time_start, time_end,
  downloadSrc = new Image();
  document.querySelector('.loader-content').classList.add('hide')
  document.querySelector('.loader').classList.remove('hide')
  time_start = new Date().getTime();
  var cacheImg = "?" + time_start;
  downloadSrc.src = imagelink + cacheImg;
  console.log(downloadSrc);
  downloadSrc.onload = function () {
    time_end = new Date().getTime();
    var timeDuration = (time_end - time_start) / 1000;
    loadedBytes = downloadSize * 8;
    totalSpeed = ((loadedBytes / timeDuration) / 1024 / 1024).toFixed(2);
    let i=0,speedOut;
    const animate = () => {
      if (i < totalSpeed){
        document.querySelector('.content').innerHTML = i.toFixed(1) + '<small>Mbps</small>';
        setTimeout(animate, 20)
        i+=1.2;
      } else {
        document.querySelector('.content').innerHTML = totalSpeed + '<small>Mbps</small>';
      }
    }
    animate();
    document.querySelector('.content').innerHTML = totalSpeed + '<small>Mbps</small>';
    document.querySelector('.loader-content').classList.remove('hide');
    document.querySelector('.loader-content').classList.add('result')
    document.querySelector('.loader').classList.add('hide');
    document.querySelector('.content').classList.remove('hide');
    e.target.innerText = "GO Again" ;
  }
})

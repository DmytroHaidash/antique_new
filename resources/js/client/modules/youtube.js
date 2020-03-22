
const videoBlocks = document.querySelectorAll('[data-youtube]');

for (i = 0; i < videoBlocks.length; i++) {

    let urlYoutube = videoBlocks[i].getAttribute('data-youtube');
    let videoId = getYoutubeVideoId(urlYoutube);
    let videoImgUrl = getYoutubeVideoImg(videoId);

    videoBlocks[i].innerHTML = `<img src="${videoImgUrl}"><svg><use xlink:href="#play-btn"></use></svg>`;

    videoBlocks[i].onclick = function () {
        this.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1 "frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`
    };

}

function getYoutubeVideoId(url) {
    let match = url.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/);
    return match[7];
}

function getYoutubeVideoImg(id) {

    return `https://img.youtube.com/vi/${id}/maxresdefault.jpg`;
}

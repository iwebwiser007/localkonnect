{{--<div class="ps-top-categories mt-40 mb-40">
  <div class="ps-container">
    <h3>{!! BaseHelper::clean($title) !!}</h3>
    <div class="row justify-content-center">
      @foreach($categories as $category)
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
        <div class="ps-block--category">
          <a class="ps-block__overlay" href="{{ $category->url }}"></a>
<img class="category-image"
  src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}"
  alt="{{ $category->name }}" />
<p>{{ $category->name }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>--}}
{{--
<style>
.ps-container1 {
  position: relative;
  overflow-x: hidden;
}

.category-wrapper1 {
  overflow-x: auto;
  /* Enable horizontal scrolling */
  overflow-y: hidden;
  white-space: nowrap;
  width: 100%;
  padding: 10px 0;
  scroll-behavior: smooth;
  /* Smooth scrolling */
  scrollbar-width: none;
  /* Firefox */
  -ms-overflow-style: none;
  /* Internet Explorer & Edge */
}

.category-wrapper1::-webkit-scrollbar {
  display: none;
  /* Chrome, Safari, Opera */
}

.category-list1 {
  display: flex;
  gap: 10px;
  flex-wrap: nowrap;
  /* Prevent wrapping */
}

.category-item1 {
  flex: 0 0 auto;
  width: 250px;
  /* Adjust width */
  text-align: center;
}

.scroll-btn1 {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: #000;
  color: #fff;
  border: none;
  padding: 10px 15px;
  cursor: pointer;
  font-size: 18px;
  /* z-index: 10; */
  z-index: 9999;
  /* Ensure button is on top */
}

.left-btn1 {
  left: 0;
}

.right-btn1 {
  right: 0;
}

.scroll-btn1:hover {
  background-color: #444;
}
</style>

<div class="ps-top-categories mt-40 mb-40">
  <div class="ps-container1">
    <h3>{!! BaseHelper::clean($title) !!}</h3>

    <!-- Left Arrow -->
    <button class="scroll-btn1 left-btn1">&lt;</button>

    <div class="category-wrapper1">
      <div class="category-list1">
        @foreach($categories as $category)
        <div class="category-item1">
          <div class="ps-block--category">
            <a class="ps-block__overlay" href="{{ $category->url }}"></a>
<img class="category-image"
  src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}"
  alt="{{ $category->name }}" />
<p>{{ $category->name }}</p>
</div>
</div>
@endforeach
</div>
</div>

<!-- Right Arrow -->
<button class="scroll-btn1 right-btn1">&gt;</button>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const container = document.querySelector(".category-wrapper1"); // Correct container for scrolling
  const leftBtn = document.querySelector(".left-btn1");
  const rightBtn = document.querySelector(".right-btn1");
  const scrollAmount = 250; // Adjust scrolling speed

  leftBtn.addEventListener("click", function() {

    container.scrollBy({
      left: -scrollAmount, // Scroll left
      behavior: "smooth"
    });
  });

  rightBtn.addEventListener("click", function() {

    container.scrollBy({
      left: scrollAmount, // Scroll right
      behavior: "smooth"
    });
  });
});
</script> --}}

{{--
<style>
.ps-container {
  position: relative;
}

.category-wrapper {
  overflow-x: hidden;
  overflow-y: hidden;
  white-space: nowrap;
  width: 100%;
  padding: 10px 0;
  scroll-behavior: smooth;
  scrollbar-width: none;
  /* Firefox */
  -ms-overflow-style: none;
  /* IE & Edge */
  cursor: grab;
  /* Mouse cursor */
}

.category-wrapper::-webkit-scrollbar {
  display: none;
  /* Chrome, Safari */
}

.category-list {
  display: flex;
  gap: 10px;
  flex-wrap: nowrap;
}

.category-item {
  flex: 0 0 auto;
  width: 250px;
  text-align: center;
}
</style>

<div class="ps-top-categories mt-40 mb-40">
  <div class="ps-container">
    <h3>{!! BaseHelper::clean($title) !!}</h3>

    <div class="category-wrapper">
      <div class="category-list">
        @foreach($categories as $category)
        <div class="category-item">
          <div class="ps-block--category">
            <a class="ps-block__overlay" href="{{ $category->url }}"></a>
<img class="category-image"
  src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}"
  alt="{{ $category->name }}" />
<p>{{ $category->name }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const container = document.querySelector(".category-wrapper");
  const scrollAmount = 250; // Scrolling distance
  let isDragging = false;
  let startX;
  let scrollLeft;

  // Auto-scroll function
  let autoScroll = setInterval(() => {
    container.scrollBy({
      left: scrollAmount,
      behavior: "smooth"
    });
  }, 2000); // Scroll every 2 seconds

  // Mouse Down Event (Start Dragging)
  container.addEventListener("mousedown", (e) => {
    isDragging = true;
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
    container.style.cursor = "grabbing";
    clearInterval(autoScroll); // Stop auto-scroll when dragging starts
  });

  // Mouse Move Event (Dragging)
  container.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX) * 1.5; // Adjust drag speed
    container.scrollLeft = scrollLeft - walk;
  });

  // Mouse Up & Leave Event (Stop Dragging)
  container.addEventListener("mouseup", () => {
    isDragging = false;
    container.style.cursor = "grab";
    resetAutoScroll(); // Restart auto-scroll when dragging stops
  });

  container.addEventListener("mouseleave", () => {
    isDragging = false;
    container.style.cursor = "grab";
    resetAutoScroll();
  });

  function resetAutoScroll() {
    clearInterval(autoScroll);
    autoScroll = setInterval(() => {
      container.scrollBy({
        left: scrollAmount,
        behavior: "smooth"
      });
    }, 2000);
  }
});
</script>--}}


{{--
<style>
.ps-container {
  position: relative;
}

.category-wrapper {
  overflow-x: hidden;
  overflow-y: hidden;
  white-space: nowrap;
  width: 100%;
  padding: 10px 0;
  scroll-behavior: smooth;
  scrollbar-width: none;
  /* Firefox */
  -ms-overflow-style: none;
  /* IE & Edge */
  cursor: grab;
}

.category-wrapper::-webkit-scrollbar {
  display: none;
}

.category-list {
  display: flex;
  gap: 10px;
  flex-wrap: nowrap;
}

.category-item {
  flex: 0 0 auto;
  width: 250px;
  text-align: center;
}

.scroll-btn {
  position: absolute;
  top: 5%;
  background-color: #000;
  color: #fff;
  border: none;
  padding: 10px 15px;
  cursor: pointer;
  font-size: 18px;
  z-index: 10;
  opacity: 0.5;
  /* Default visibility low */
}

.left-btn {
  left: 45%;
}

.right-btn {
  right: 45%;
}

.scroll-btn:focus {
  opacity: 1;
  /* Button becomes visible on focus */
}
</style>

<div class="ps-top-categories mt-40 mb-40">
  <div class="ps-container">
    <h3>{!! BaseHelper::clean($title) !!}</h3>

    <!-- Left Arrow (Only Works After Double Click) -->
    <button class="scroll-btn left-btn" tabindex="0">&lt;</button>

    <div class="category-wrapper">
      <div class="category-list">
        @foreach($categories as $category)
        <div class="category-item">
          <div class="ps-block--category">
            <a class="ps-block__overlay" href="{{ $category->url }}"></a>
<img class="category-image"
  src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}"
  alt="{{ $category->name }}" />
<p>{{ $category->name }}</p>
</div>
</div>
@endforeach
</div>
</div>

<!-- Right Arrow (Only Works After Double Click) -->
<button class="scroll-btn right-btn" tabindex="0">&gt;</button>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const container = document.querySelector(".category-wrapper");
  const leftBtn = document.querySelector(".left-btn");
  const rightBtn = document.querySelector(".right-btn");
  const scrollAmount = 250;
  let leftClickCount = 0;
  let rightClickCount = 0;

  // Auto-scroll function
  let autoScroll = setInterval(() => {
    container.scrollBy({
      left: scrollAmount,
      behavior: "smooth"
    });
  }, 2000);

  // Left button click (Only works after 2 clicks)
  leftBtn.addEventListener("click", function(event) {
    leftClickCount++;
    if (leftClickCount >= 2) {
      container.scrollBy({
        left: -scrollAmount,
        behavior: "smooth"
      });
      leftClickCount = 0; // Reset count after action
    }
  });

  // Right button click (Only works after 2 clicks)
  rightBtn.addEventListener("click", function(event) {
    rightClickCount++;
    if (rightClickCount >= 2) {
      container.scrollBy({
        left: scrollAmount,
        behavior: "smooth"
      });
      rightClickCount = 0; // Reset count after action
    }
  });

  // Drag to scroll
  let isDragging = false;
  let startX;
  let scrollLeft;

  container.addEventListener("mousedown", (e) => {
    isDragging = true;
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
    container.style.cursor = "grabbing";
    clearInterval(autoScroll);
  });

  container.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX) * 1.5;
    container.scrollLeft = scrollLeft - walk;
  });

  container.addEventListener("mouseup", () => {
    isDragging = false;
    container.style.cursor = "grab";
    resetAutoScroll();
  });

  container.addEventListener("mouseleave", () => {
    isDragging = false;
    container.style.cursor = "grab";
    resetAutoScroll();
  });

  function resetAutoScroll() {
    clearInterval(autoScroll);
    autoScroll = setInterval(() => {
      container.scrollBy({
        left: scrollAmount,
        behavior: "smooth"
      });
    }, 2000);
  }
});
</script>


--}}


<style>
.ps-container {
  position: relative;
}

.category-wrapper {
  overflow: hidden;
  white-space: nowrap;
  width: 100%;
  padding: 10px 0;
  scroll-behavior: smooth;
  display: flex;
  flex-wrap: nowrap;
  cursor: grab;
}

.category-list {
  display: flex;
  gap: 10px;
  flex-wrap: nowrap;
}

.category-item {
  flex: 0 0 auto;
  width: 150px;
  /* Image chhoti kar di */
  text-align: center;
}

.category-image {
  width: 100px;
  /* Image size chhota */
  height: 100px;
  /* Maintain aspect ratio */
  object-fit: cover;
  border-radius: 10px;
}
</style>

<div class="ps-top-categories mt-40 mb-40">
  <div class="ps-container">
    <h3>{!! BaseHelper::clean($title) !!}</h3>
    <div class="category-wrapper">
      <div class="category-list">
        @foreach($categories as $category)
        <div class="category-item">
          <div class="ps-block--category">
            <a class="ps-block__overlay" href="{{ $category->url }}"></a>
            <img class="category-image"
              src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}"
              alt="{{ $category->name }}" />
            <p>{{ $category->name }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const container = document.querySelector(".category-wrapper");
  const list = document.querySelector(".category-list");
  const scrollAmount = 200; // Har baar 200px move karega

  // Duplicate categories for smooth infinite scrolling
  list.innerHTML += list.innerHTML;

  function startAutoScroll() {
    let scrollInterval = setInterval(() => {
      container.scrollLeft += scrollAmount;

      // Jaise hi last category scroll ho, fir se first category aa jaaye
      if (container.scrollLeft >= list.scrollWidth / 2) {
        container.scrollLeft = 0;
      }
    }, 2000); // Har 2 sec baad scroll karega

    // Drag to scroll
    let isDragging = false;
    let startX;
    let scrollLeft;

    container.addEventListener("mousedown", (e) => {
      isDragging = true;
      startX = e.pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
      container.style.cursor = "grabbing";
      clearInterval(scrollInterval);
    });

    container.addEventListener("mousemove", (e) => {
      if (!isDragging) return;
      e.preventDefault();
      const x = e.pageX - container.offsetLeft;
      const walk = (x - startX) * 2;
      container.scrollLeft = scrollLeft - walk;
    });

    container.addEventListener("mouseup", () => {
      isDragging = false;
      container.style.cursor = "grab";
      scrollInterval = setInterval(() => {
        container.scrollLeft += scrollAmount;
        if (container.scrollLeft >= list.scrollWidth / 2) {
          container.scrollLeft = 0;
        }
      }, 2000);
    });

    container.addEventListener("mouseleave", () => {
      isDragging = false;
      container.style.cursor = "grab";
    });

  }

  startAutoScroll();
});
</script>
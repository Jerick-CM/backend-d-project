<template>
  <div id="home-page">
    <b-row>
      <b-col cols="12" md="6" lg="8">
        <b-carousel id="promo-slide"
                    indicators
                    v-bind:interval="4000"
                    v-model="slide">
          <b-carousel-slide text="Staff Reward Program"
                            caption="Deloitte"
                            img-src="https://images.unsplash.com/photo-1518600570419-81324064e9ae?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=04af4a3ac17780fdc82adf7e68b1f6ec&auto=format&fit=crop&w=2100&q=80"
          ></b-carousel-slide>
          <b-carousel-slide img-src="https://images.unsplash.com/photo-1442504028989-ab58b5f29a4a?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=d700e1019e9b1ed821cf067403b23171&auto=format&fit=crop&w=2100&q=80">
          </b-carousel-slide>
          <b-carousel-slide>
            <img slot="img" class="d-block img-fluid w-100" width="1024" height="480"
                src="https://images.unsplash.com/photo-1533022544462-adf3bbb1b78f?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=56a09599b1d703725d3954727ada8c6a&auto=format&fit=crop&w=2222&q=80" alt="image slot">
          </b-carousel-slide>
        </b-carousel>
      </b-col>
      <b-col cols="12" md="6" lg="4">
        <reward-giving></reward-giving>
      </b-col>
    </b-row>
    <br>
    <b-row>
      <b-col cols="12">
        <activity-board></activity-board>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  data () {
    return {
      slide: 0,
    }
  }
}
</script>

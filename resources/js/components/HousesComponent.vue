<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form v-on:submit.prevent="getHouses">
                    <div class="form-row">
                        <input-component v-model="filters.name"
                                         id="name"
                                         name="name"
                                         label="Name"
                                         placeholder="Name"
                                         :width="3"
                                         :errors="errors['filter.name']" />

                        <input-component v-model="filters.price_from"
                                         type="number"
                                         id="price-from"
                                         name="price-from"
                                         label="Price From"
                                         placeholder="100000"
                                         :width="2"
                                         :errors="errors['filter.price_from']" />

                        <input-component v-model="filters.price_to"
                                         type="number"
                                         id="price-to"
                                         name="price-to"
                                         label="Price To"
                                         placeholder="100000"
                                         :width="2"
                                         :errors="errors['filter.price_to']" />

                        <input-component v-model="filters.bedrooms"
                                         type="number"
                                         id="bedrooms"
                                         name="bedrooms"
                                         label="Bedrooms"
                                         placeholder="2"
                                         :width="1"
                                         :errors="errors['filter.bedrooms']" />

                        <input-component v-model="filters.bathrooms"
                                         type="number"
                                         id="bathrooms"
                                         name="bathrooms"
                                         label="Bathrooms"
                                         placeholder="2"
                                         :width="1"
                                         :errors="errors['filter.bathrooms']" />

                        <input-component v-model="filters.storeys"
                                         type="number"
                                         id="storeys"
                                         name="storeys"
                                         label="Storeys"
                                         placeholder="2"
                                         :width="1"
                                         :errors="errors['filter.storeys']" />

                        <input-component v-model="filters.garages"
                                         type="number"
                                         id="garages"
                                         name="garages"
                                         label="Garages"
                                         placeholder="2"
                                         :width="1"
                                         :errors="errors['filter.garages']" />

                        <div class="form-group col-md-1 position-relative">
                            <button :disabled="isLoading" type="submit" class="btn btn-primary absolute-bottom">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12">
                <div v-if="isLoading" class="text-center">Loading...</div>
                <table v-else class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" :class="sort === 'name' ? 'asc' : sort === '-name' ? 'desc' : ''" v-on:click="sortBy('name')">Name</th>
                        <th scope="col" :class="sort === 'price' ? 'asc' : sort === '-price' ? 'desc' : ''" v-on:click="sortBy('price')">Price</th>
                        <th scope="col" :class="sort === 'bedrooms' ? 'asc' : sort === '-bedrooms' ? 'desc' : ''" v-on:click="sortBy('bedrooms')">Bedrooms</th>
                        <th scope="col" :class="sort === 'bathrooms' ? 'asc' : sort === '-bathrooms' ? 'desc' : ''" v-on:click="sortBy('bathrooms')">Bathrooms</th>
                        <th scope="col" :class="sort === 'storeys' ? 'asc' : sort === '-storeys' ? 'desc' : ''" v-on:click="sortBy('storeys')">Storeys</th>
                        <th scope="col" :class="sort === 'garages' ? 'asc' : sort === '-garages' ? 'desc' : ''" v-on:click="sortBy('garages')">Garages</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="house in houses" :key="house.id">
                        <th scope="row">{{ house.id }}</th>
                        <td>{{ house.name }}</td>
                        <td>{{ house.price }}</td>
                        <td>{{ house.bedrooms }}</td>
                        <td>{{ house.bathrooms }}</td>
                        <td>{{ house.storeys }}</td>
                        <td>{{ house.garages }}</td>
                    </tr>
                    <tr v-if="houses.length === 0" >
                        <td colspan="7" class="text-center">No Data</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
  import axios from 'axios';
  import { query } from 'js-query-builder';
  import InputComponent from './InputComponent';

  export default {
    components: {
      InputComponent,
    },
    data: () => {
      return {
        isLoading: false,
        houses: [],
        filters: {
          name: '',
          price_from: '',
          price_to: '',
          bedrooms: '',
          bathrooms: '',
          storeys: '',
          garages: '',
        },
        sort: '',
        errors: {},
      }
    },
    created() {
      this.getHouses();
    },
    methods: {
      sortBy(sort) {
        if (this.sort === sort) {
          this.sort = '-' + sort
        } else if (this.sort === '-' + sort) {
          this.sort = '';
        } else {
          this.sort = sort;
        }
      },
      getHouses() {
        this.isLoading = true;

        let url = query('/houses');

        this.sort && url.sort(this.sort);

        for (let filterName in this.filters) {
          this.filters[filterName] && url.filter(filterName, this.filters[filterName]);
        }

        axios
          .get(url.build())
          .then(({data: {data}}) => {
            this.houses = data;
            this.isLoading = false;
            this.errors = {};
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            this.isLoading = false;
          });

      }
    },
    watch: {
      sort: function () {
        this.getHouses();
      }
    }
  };
</script>

<style lang="sass">
    .content
        margin: 150px 0 0
    .absolute
        &-bottom
            position: absolute
            bottom: 0
    th
        position: relative
        &.asc::after
            content: ''
            border-bottom: 2px solid #0069d9
            border-right: 2px solid #0069d9
            position: absolute
            width: 10px
            height: 10px
            right: 15px
            bottom: 20px
            transform: rotateZ(45deg)
        &.desc::after
            content: ''
            border-top: 2px solid #0069d9
            border-left: 2px solid #0069d9
            position: absolute
            width: 10px
            height: 10px
            right: 15px
            top: 22px
            transform: rotateZ(45deg)

</style>

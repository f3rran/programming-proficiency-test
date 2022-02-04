<template>
  <div id="app">
    <table border="1">
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    User
                </th>
                <th>
                    Type
                </th>
                <th>
                    Rented from
                </th>
                <th>
                    Rented to
                </th>
                <th>
                    Actually rented
                </th>
                <th>
                    Rented months
                </th>
            </tr>
            <tr>
                <td>
                  &nbsp;
                </td>
                <td>
                    <select
                        name="userSearch"
                        id="userSearch"
                        v-model="userSearch"
                        @change="filterUser"
                    >
                      <option value="0"></option>
                      <option v-for="user in users" v-bind:key="user.id" :value="user.id">
                        {{user.name}}
                      </option>
                    </select>
                </td>
                <td>
                    <select
                        name="typeSearch"
                        id="typeSearch"
                        v-model="typeSearch"
                        @change="filterType"
                    >
                      <option value="0"></option>
                      <option v-for="type in propertyTypes" v-bind:key="type.id" :value="type.id">
                        {{type.name}}
                      </option>
                    </select>
                </td>
                <td>
                    <input type="date"
                        name="fromSearchMin"
                        id="fromSearchMin"
                        v-model="fromSearchMin"
                        @change="filterFrom"
                    >
                    to
                    <input type="date"
                        name="fromSearchMax"
                        id="fromSearchMax"
                        v-model="fromSearchMax"
                        @change="filterFrom"
                    >
                </td>
                <td>
                    <input type="date"
                        name="toSearchMin"
                        id="toSearchMin"
                        v-model="toSearchMin"
                        @change="filterTo"
                    >
                    to
                    <input type="date"
                        name="toSearchMax"
                        id="toSearchMax"
                        v-model="toSearchMax"
                        @change="filterTo"
                    >
                </td>
                <td>
                    &nbsp;
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="property in showProperties" v-bind:key="property.id">
                <td>
                    {{property.name}}
                </td>
                <td>
                    {{users.find(x => x.id === property.userId).name}}
                </td>
                <td>
                    {{
                        (propertyTypes.find(x => x.id === property.typeId) !== null)
                        ? propertyTypes.find(x => x.id === property.typeId).name
                        : ' - '
                    }}
                </td>
                <td>
                    {{
                        (property.rentedFrom !== null)
                        ? property.rentedFrom.toLocaleDateString("es-ES")
                        : ' - '
                    }}
                </td>
                <td>
                    {{
                        (property.rentedTo !== null)
                        ? property.rentedTo.toLocaleDateString("es-ES")
                        : ' - '
                    }}
                </td>
                <td>
                    {{
                        (property.rentedTo > new Date())
                        ? 'Yes'
                        : 'No'
                    }}
                </td>
                <td>
                    {{ monthDifferente(property) }}
                </td>
            </tr>
        </tbody>
    </table>
  </div>
</template>

<script>
import { users, propertyTypes, properties } from '@/mocks/api';

export default {
  name: 'App',
  data: () => ({
    users,
    propertyTypes,
    properties,

    showProperties: Array,
    userSearch: 0,
    typeSearch: 0,
    fromSearchMin: null,
    fromSearchMax: null,
    toSearchMin: null,
    toSearchMax: null,
  }),
  methods: {
    monthDifferente(propertyId) {
      const endDate = propertyId.rentedTo;
      const startDate = propertyId.rentedFrom;

      if (endDate === null || startDate === null) {
        return ' - ';
      }

      const yearsInMonthsDiff = (endDate.getFullYear() - startDate.getFullYear()) * 12;
      const onlyMonthsDiff = (endDate.getMonth() - startDate.getMonth());
      const totalMonths = yearsInMonthsDiff + onlyMonthsDiff;
      return totalMonths;
    },
    filterUser() {
      const userId = parseInt(this.userSearch, 10);
      if (userId !== 0) {
        this.showProperties = properties.filter((property) => property.userId === userId);
      } else {
        this.showProperties = properties;
      }
    },
    filterType() {
      const typeId = parseInt(this.typeSearch, 10);
      if (typeId !== 0) {
        this.showProperties = properties.filter((property) => property.typeId === typeId);
      } else {
        this.showProperties = properties;
      }
    },
    filterFrom() {
      let minDate = null;
      let maxDate = null;
      if (this.fromSearchMin !== null && this.fromSearchMin !== '') {
        minDate = new Date(this.fromSearchMin);
      }
      if (this.fromSearchMax !== null && this.fromSearchMax !== '') {
        maxDate = new Date(this.fromSearchMax);
      }

      if (minDate !== null && maxDate !== null) {
        this.showProperties = properties.filter((property) => {
          const from = property.rentedFrom;
          return minDate <= from && from <= maxDate;
        });
      } else {
        this.showProperties = properties;
      }
    },
    filterTo() {
      let minDate = null;
      let maxDate = null;
      if (this.toSearchMin !== null && this.toSearchMin !== '') {
        minDate = new Date(this.toSearchMin);
      }
      if (this.toSearchMax !== null && this.toSearchMax !== '') {
        maxDate = new Date(this.toSearchMax);
      }

      if (minDate !== null && maxDate !== null) {
        this.showProperties = properties.filter((property) => {
          const from = property.rentedTo;
          return minDate <= from && from <= maxDate;
        });
      } else {
        this.showProperties = properties;
      }
    },
  },
  mounted() {
    this.showProperties = properties;
  },
};
</script>

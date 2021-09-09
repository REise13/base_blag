using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using WpfApp_;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;

namespace WpfApp_
{
    static class GeoHelp
    {
        //Nominatim tool OpenSource http://nominatim.org/
        public static string GetCoordinateByCity(string city)
        {
            var client = new RestSharp.RestClient($"https://nominatim.openstreetmap.org/search?city={city}&country=Украина&format=geojson");
            var request = new RestSharp.RestRequest(RestSharp.Method.GET);
            request.AddHeader("GET", "application/json");
            request.OnBeforeDeserialization = resp => { resp.ContentType = "application/json"; };
            var q = client.Execute(request);
            var c = JObject.Parse(q.Content);

            //Десятичные градусы: coordsX, coordsY
            string coordsX = (string)c["features"][0]["bbox"][1];
            string coordsY = (string)c["features"][0]["bbox"][0];

            return $"{coordsX},{coordsY}";
        }
    }
}

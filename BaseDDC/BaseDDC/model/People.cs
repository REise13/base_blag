using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class People
    {
        public People()
        {
            Profile = new HashSet<Profile>();
        }

        public int Id { get; set; }
        public string SName { get; set; }
        public string Name { get; set; }
        public string Patr { get; set; }
        public int Year { get; set; }
        public string Inn { get; set; }
        public string Email { get; set; }
        public string Phone { get; set; }
        public string Passport { get; set; }
        public int? IdCity { get; set; }
        public int? IdGender { get; set; }

        public City IdCityNavigation { get; set; }
        public Gender IdGenderNavigation { get; set; }
        public ICollection<Profile> Profile { get; set; }
    }
}

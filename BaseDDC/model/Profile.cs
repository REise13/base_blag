using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Profile
    {
        public Profile()
        {
            Crosscategory = new HashSet<Crosscategory>();
            Crossneed = new HashSet<Crossneed>();
            Crosstraining = new HashSet<Crosstraining>();
            Help = new HashSet<Help>();
        }

        public int Id { get; set; }
        public int IdPeople { get; set; }
        public sbyte? ForcedMigrant { get; set; }
        public sbyte? DestroyedHouse { get; set; }
        public int? IdTypeOfHouse { get; set; }
        public int? IdTypeHeating { get; set; }
        public int? NumbOfChild { get; set; }
        public int? IdFamiliy { get; set; }
        public string Note { get; set; }
        public DateTime RegDate { get; set; }

        public Family IdFamiliyNavigation { get; set; }
        public People IdPeopleNavigation { get; set; }
        public HeatingType IdTypeHeatingNavigation { get; set; }
        public TypeOfHouse IdTypeOfHouseNavigation { get; set; }
        public ICollection<Crosscategory> Crosscategory { get; set; }
        public ICollection<Crossneed> Crossneed { get; set; }
        public ICollection<Crosstraining> Crosstraining { get; set; }
        public ICollection<Help> Help { get; set; }
    }
}

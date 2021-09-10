using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class DTO_Profile_Get
    {

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

        public DTO_Family IdFamiliyNavigation { get; set; }
        public DTO_People_Get IdPeopleNavigation { get; set; }
        public DTO_Heating_Type IdTypeHeatingNavigation { get; set; }
        public DTO_Type_of_house IdTypeOfHouseNavigation { get; set; }
        public List<DTO_CrossCategory> CrossCategory { get; set; }
        public List<DTO_CrossNeed> CrossNeed { get; set; }
        public List<DTO_CrossTraining> CrossTraining { get; set; }
    }
}

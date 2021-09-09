using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class InfoCollection
    {
        public List<DTO_City> cities { get; set; }
        public List<DTO_Category> categories { get; set; }
        public List<DTO_Gender> genders { get; set; }
        public List<DTO_Heating_Type> heating_Types { get; set; }
        public List<DTO_Need> needs { get; set; }
        public List<DTO_Training> trainings { get; set; }
        public List<DTO_Type_of_house> type_Of_Houses { get; set; }
        public List<DTO_Donor> donors { get; set; }
        public List<DTO_HelpType> helpTypes { get; set; }
        public List<DTO_User_role> user_Roles { get; set; }
  
    }
}

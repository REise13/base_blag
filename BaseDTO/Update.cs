using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class Update
    {
        public int id { get; set; }
        public List<int> to_add { get; set; }
        public List<int> to_delete { get; set; }
    }
}
